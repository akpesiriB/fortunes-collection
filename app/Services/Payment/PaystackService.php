<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Inventory;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaystackService
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = (string) config('services.paystack.secret_key', '');
        $this->publicKey = (string) config('services.paystack.public_key', '');
        $this->baseUrl = (string) config('services.paystack.payment_url', 'https://api.paystack.co');
    }

    /**
     * Initialize Paystack transaction server-side.
     */
    public function initializeTransaction(Order $order, string $callbackUrl): array
    {
        $reference = 'PSTK_' . $order->order_number . '_' . bin2hex(random_bytes(4));
        $amountInKobo = (int) round($order->total_amount * 100);

        // Record pending payment in database
        $payment = Payment::create([
            'order_id' => $order->id,
            'provider' => 'paystack',
            'reference' => $reference,
            'amount' => $order->total_amount,
            'currency' => 'NGN',
            'status' => 'pending',
        ]);

        $payload = [
            'email' => $order->customer_email,
            'amount' => $amountInKobo,
            'reference' => $reference,
            'callback_url' => $callbackUrl,
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
            ],
            'channels' => ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
        ];

        // Attempt live/sandbox API call
        try {
            if ($this->secretKey && !str_starts_with($this->secretKey, 'sk_test_fc_demo')) {
                $response = Http::withToken($this->secretKey)
                    ->timeout(15)
                    ->post("{$this->baseUrl}/transaction/initialize", $payload);

                if ($response->successful() && $response->json('status') === true) {
                    $data = $response->json('data');
                    return [
                        'success' => true,
                        'authorization_url' => $data['authorization_url'],
                        'access_code' => $data['access_code'],
                        'reference' => $reference,
                    ];
                }

                Log::warning('Paystack initialization response failed', ['response' => $response->json()]);
            }
        } catch (\Exception $e) {
            Log::error('Paystack initialization exception: ' . $e->getMessage());
        }

        // Seamless local demo / sandbox fallback simulation
        $demoVerifyUrl = route('checkout.simulate.paystack', ['reference' => $reference]);

        return [
            'success' => true,
            'authorization_url' => $demoVerifyUrl,
            'access_code' => 'DEMO_' . bin2hex(random_bytes(5)),
            'reference' => $reference,
            'is_simulation' => true,
        ];
    }

    /**
     * Verify transaction with Paystack API server-side.
     */
    public function verifyTransaction(string $reference): array
    {
        // Check if simulation reference
        if (str_starts_with($reference, 'PSTK_SIM_') || str_starts_with($reference, 'PSTK_')) {
            $payment = Payment::where('reference', $reference)->first();
            if ($payment && str_starts_with($this->secretKey, 'sk_test_fc_demo')) {
                return [
                    'success' => true,
                    'status' => 'success',
                    'amount' => (int) round($payment->amount * 100),
                    'channel' => 'card',
                    'gateway_response' => 'Successful (Demo Sandbox)',
                    'transaction_id' => 'TRX_' . bin2hex(random_bytes(6)),
                ];
            }
        }

        try {
            $response = Http::withToken($this->secretKey)
                ->timeout(15)
                ->get("{$this->baseUrl}/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('status') === true) {
                $data = $response->json('data');
                return [
                    'success' => $data['status'] === 'success',
                    'status' => $data['status'],
                    'amount' => $data['amount'],
                    'channel' => $data['channel'] ?? 'card',
                    'gateway_response' => $data['gateway_response'] ?? 'Approved',
                    'transaction_id' => (string) ($data['id'] ?? ''),
                    'raw' => $data,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Paystack verification error: ' . $e->getMessage());
        }

        return [
            'success' => false,
            'message' => 'Unable to verify payment with provider.',
        ];
    }

    /**
     * Validate Paystack Webhook HMAC SHA512 signature.
     */
    public function validateWebhookSignature(string $payload, ?string $signatureHeader): bool
    {
        if (empty($signatureHeader) || empty($this->secretKey)) {
            return false;
        }

        $computedSignature = hash_hmac('sha512', $payload, $this->secretKey);
        return hash_equals($computedSignature, $signatureHeader);
    }

    /**
     * Complete order and deplete inventory atomically.
     */
    public function processSuccessfulPayment(Order $order, Payment $payment, array $verificationData): void
    {
        DB::transaction(function () use ($order, $payment, $verificationData) {
            // Update Payment record
            $payment->update([
                'status' => 'successful',
                'channel' => $verificationData['channel'] ?? 'card',
                'transaction_id' => $verificationData['transaction_id'] ?? null,
                'gateway_response' => $verificationData['gateway_response'] ?? 'Successful',
                'raw_payload' => $verificationData['raw'] ?? null,
                'verified_at' => now(),
            ]);

            // Update Order record
            $order->update([
                'status' => 'paid',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Atomically decrement actual inventory and release reserved count
            foreach ($order->items as $item) {
                if ($item->product_variant_id) {
                    $variant = ProductVariant::find($item->product_variant_id);
                    if ($variant) {
                        $variant->decrement('stock_quantity', $item->quantity);
                    }

                    $inventory = Inventory::where('product_variant_id', $item->product_variant_id)->first();
                    if ($inventory) {
                        $inventory->decrement('stock_count', $item->quantity);
                        $inventory->decrement('reserved_count', min($inventory->reserved_count, $item->quantity));
                    }
                }
            }
        });
    }
}
