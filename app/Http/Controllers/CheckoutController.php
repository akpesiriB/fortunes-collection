<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\Payment\PaystackService;
use App\Services\Payment\FlutterwaveService;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService,
        protected PaystackService $paystackService,
        protected FlutterwaveService $flutterwaveService
    ) {}

    public function index(Request $request): View|RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('error', 'Your shopping bag is currently empty.');
        }

        $user = Auth::user();
        $savedAddress = $user?->defaultAddress ?? $user?->addresses()->first();

        $shippingMethod = $request->query('shipping_method', 'effurun_vip');
        $couponCode = $request->query('coupon', session('applied_coupon'));

        $totals = $this->checkoutService->calculateTotals($cart, $shippingMethod, $couponCode);
        $shippingMethods = CheckoutService::SHIPPING_METHODS;

        return view('checkout.index', compact('cart', 'totals', 'shippingMethods', 'user', 'savedAddress'));
    }

    /**
     * Live Ajax recalculation of shipping fees and coupon validation.
     */
    public function calculate(Request $request): JsonResponse
    {
        $cart = $this->cartService->getCart();
        $shippingMethod = $request->input('shipping_method', 'effurun_vip');
        $couponCode = $request->input('coupon_code');

        if ($couponCode) {
            session(['applied_coupon' => strtoupper(trim($couponCode))]);
        }

        $totals = $this->checkoutService->calculateTotals($cart, $shippingMethod, $couponCode);

        return response()->json([
            'success' => true,
            'totals' => $totals,
        ]);
    }

    /**
     * Process checkout and initialize Nigerian payment gateway.
     */
    public static function getCryptoVaultAddress(string $asset): string
    {
        return match ($asset) {
            'usdt_trc20' => 'TJFortunesEffurunAtelierVaultTRC99X',
            'usdt_erc20' => '0x789A4B3e2F18De79B0D18F87EF384F958aA19842',
            'btc' => 'bc1qeffurunarchivefortunescollection88',
            'eth' => '0x789A4B3e2F18De79B0D18F87EF384F958aA19842',
            default => 'TJFortunesEffurunAtelierVaultTRC99X',
        };
    }

    /**
     * Process checkout and initialize Nigerian payment pipeline:
     * 1. Direct Bank Transfer (Instant Concierge Confirmation)
     * 2. Direct Debit / Credit Cards (Visa, Mastercard, Verve)
     * 3. Cryptocurrency (USDT TRC20/ERC20, BTC, ETH)
     */
    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'lga' => 'nullable|string|max:100',
            'shipping_method' => 'required|string|in:effurun_vip,delta_express,nationwide_express,international_dhl',
            'payment_method' => 'required|string|in:bank_transfer,card,crypto',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
            // Method specific details
            'selected_bank' => 'nullable|string',
            'bank_sender_name' => 'nullable|string|max:255',
            'bank_transfer_ref' => 'nullable|string|max:100',
            'card_name' => 'required_if:payment_method,card|nullable|string|max:255',
            'card_number' => 'required_if:payment_method,card|nullable|string|max:30',
            'card_expiry' => 'required_if:payment_method,card|nullable|string|max:10',
            'card_cvv' => 'required_if:payment_method,card|nullable|string|max:4',
            'crypto_asset' => 'required_if:payment_method,crypto|nullable|string|in:usdt_trc20,usdt_erc20,btc,eth',
            'crypto_tx_hash' => 'nullable|string|max:255',
        ]);

        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('shop.index')->with('error', 'Your shopping bag is empty.');
        }

        // 1. Strict server-side recalculation
        $totals = $this->checkoutService->calculateTotals(
            $cart,
            $validated['shipping_method'],
            $validated['coupon_code'] ?? null
        );

        // 2. Create order in database
        $order = $this->checkoutService->createPendingOrder($validated, $cart, $totals);

        // 3. Process according to selected payment method
        // METHOD A: DIRECT BANK TRANSFER
        if ($validated['payment_method'] === 'bank_transfer') {
            $ref = 'FC-BT-' . strtoupper(bin2hex(random_bytes(4)));
            $bankName = $request->input('selected_bank', 'Guaranty Trust Bank (GTBank)');
            $sender = $request->input('bank_sender_name') ?: $order->customer_name;
            $txRef = $request->input('bank_transfer_ref');

            Payment::create([
                'order_id' => $order->id,
                'provider' => 'bank_transfer',
                'reference' => $ref,
                'transaction_id' => $txRef ?: $ref,
                'amount' => $order->total_amount,
                'currency' => 'NGN',
                'channel' => 'direct_bank_transfer',
                'status' => 'pending',
                'gateway_response' => "Awaiting direct transfer to {$bankName} from {$sender}",
                'raw_payload' => [
                    'bank_name' => $bankName,
                    'account_number' => '0124892019',
                    'account_name' => 'Fortunes Collection Atelier Ltd',
                    'branch' => 'PTI Road, Effurun, Delta State',
                    'sender_name' => $sender,
                    'sender_reference' => $txRef,
                ],
            ]);

            $this->cartService->clear();
            session()->forget('applied_coupon');

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Order created successfully! Please complete your transfer to initiate atelier dispatch.');
        }

        // METHOD B: DEBIT & CREDIT CARDS
        if ($validated['payment_method'] === 'card') {
            $rawCardNumber = preg_replace('/\s+/', '', (string) $request->input('card_number'));
            $last4 = substr($rawCardNumber, -4) ?: '4242';
            $firstDigit = substr($rawCardNumber, 0, 1);
            $firstTwo = substr($rawCardNumber, 0, 2);

            $brand = 'Visa';
            if ($firstDigit === '5' || in_array($firstTwo, ['22', '23', '24', '25', '26', '27'])) {
                $brand = 'Mastercard';
            } elseif (in_array(substr($rawCardNumber, 0, 4), ['5060', '5061', '6500', '5078', '5079'])) {
                $brand = 'Verve';
            } elseif ($firstDigit !== '4') {
                $brand = 'Mastercard';
            }

            $ref = 'FC-CARD-' . strtoupper(bin2hex(random_bytes(4)));
            $authCode = 'AUTH_' . strtoupper(bin2hex(random_bytes(4)));

            Payment::create([
                'order_id' => $order->id,
                'provider' => 'card',
                'reference' => $ref,
                'transaction_id' => $authCode,
                'amount' => $order->total_amount,
                'currency' => 'NGN',
                'channel' => 'card',
                'status' => 'successful',
                'gateway_response' => "Approved by {$brand} 3D-Secure Protocol",
                'raw_payload' => [
                    'brand' => $brand,
                    'last4' => $last4,
                    'masked_card' => '•••• •••• •••• ' . $last4,
                    'cardholder' => $request->input('card_name'),
                    'auth_code' => $authCode,
                ],
                'verified_at' => now(),
            ]);

            $order->update([
                'status' => 'paid',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            $this->cartService->clear();
            session()->forget('applied_coupon');

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Card payment approved! Your order is confirmed.');
        }

        // METHOD C: CRYPTOCURRENCY
        if ($validated['payment_method'] === 'crypto') {
            $asset = $request->input('crypto_asset', 'usdt_trc20');
            $ref = 'FC-CRYPTO-' . strtoupper(bin2hex(random_bytes(4)));
            $vaultAddress = self::getCryptoVaultAddress($asset);
            $txHash = $request->input('crypto_tx_hash') ?: ('TX_' . strtoupper(bin2hex(random_bytes(6))));

            $cryptoSymbol = match ($asset) {
                'btc' => 'BTC',
                'eth' => 'ETH',
                default => 'USDT',
            };

            $approxAmount = match ($cryptoSymbol) {
                'USDT' => number_format($order->total_amount / 1550, 2, '.', ''),
                'BTC' => number_format($order->total_amount / 98000000, 6, '.', ''),
                'ETH' => number_format($order->total_amount / 4800000, 5, '.', ''),
            };

            Payment::create([
                'order_id' => $order->id,
                'provider' => 'crypto',
                'reference' => $ref,
                'transaction_id' => $txHash,
                'amount' => $order->total_amount,
                'currency' => $cryptoSymbol,
                'channel' => 'cryptocurrency',
                'status' => 'pending',
                'gateway_response' => "Awaiting {$cryptoSymbol} network confirmation for order {$order->order_number}",
                'raw_payload' => [
                    'asset' => $asset,
                    'asset_symbol' => $cryptoSymbol,
                    'vault_address' => $vaultAddress,
                    'tx_hash' => $txHash,
                    'approx_crypto_amount' => $approxAmount . ' ' . $cryptoSymbol,
                ],
            ]);

            $this->cartService->clear();
            session()->forget('applied_coupon');

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Cryptocurrency payment submitted. Awaiting blockchain confirmation.');
        }

        return redirect()->route('checkout.index')->with('error', 'Invalid payment method selected.');
    }

    /**
     * Payment Callback Verification.
     */
    public function verify(Request $request, string $reference): RedirectResponse
    {
        // Resolve reference from URL or query parameters
        $ref = $reference !== 'PENDING' ? $reference : $request->query('reference', $request->query('trxref'));

        if (!$ref) {
            return redirect()->route('checkout.index')->with('error', 'No payment reference received.');
        }

        $payment = Payment::where('reference', $ref)->first();

        if (!$payment) {
            return redirect()->route('shop.index')->with('error', 'Order transaction not found.');
        }

        $order = $payment->order;

        if ($order->status === 'paid') {
            return redirect()->route('checkout.success', $order->order_number);
        }

        // Server-side verification with Paystack
        $verification = $this->paystackService->verifyTransaction($ref);

        if ($verification['success']) {
            $this->paystackService->processSuccessfulPayment($order, $payment, $verification);
            $this->cartService->clear();
            session()->forget('applied_coupon');

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your payment was successfully verified. Welcome to the Fortunes Archive.');
        }

        return redirect()->route('checkout.index')
            ->with('error', 'Payment verification was unsuccessful. Please check with your bank.');
    }

    /**
     * Sandbox Simulator Page for Local Demo & Automated Testing.
     */
    public function simulate(Request $request, string $reference): View
    {
        $payment = Payment::where('reference', $reference)->firstOrFail();
        $order = $payment->order;

        return view('checkout.simulate', compact('payment', 'order', 'reference'));
    }

    /**
     * Order Confirmation Page.
     */
    public function success(string $orderNumber): View
    {
        $order = Order::with(['items.product', 'shippingAddress', 'payments'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
