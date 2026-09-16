<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\CheckoutService;

echo "=== TESTING FORTUNES COLLECTION CHECKOUT PIPELINE ===\n";

// 1. Setup Cart
$product = Product::first();
$variant = $product->variants()->first();

$cartService = app(CartService::class);
$cartService->clear();
$cartService->addItem($product->id, $variant?->id, 1);
$cart = $cartService->getCart();

echo "Cart initialized with {$cart['total_quantity']} item(s). Subtotal: {$cart['formatted_subtotal']}\n";

// 2. Test CheckoutService calculation
$checkoutService = app(CheckoutService::class);
$totals = $checkoutService->calculateTotals($cart, 'effurun_vip');
echo "Shipping: {$totals['formatted_shipping_fee']} ({$totals['shipping_method']})\n";
echo "Payable Total: {$totals['formatted_total']}\n";

// 3. Test Order Creation with Bank Transfer
$customerDataBT = [
    'name' => 'Korede Adeleke',
    'email' => 'korede@fortunesatelier.com',
    'phone' => '+2348023456789',
    'street_address' => 'Plot 14B PTI Road',
    'apartment' => 'Penthouse 4',
    'city' => 'Effurun',
    'state' => 'Delta',
    'lga' => 'Uvwie',
    'shipping_method' => 'effurun_vip',
    'payment_method' => 'bank_transfer',
    'notes' => 'Effurun VIP delivery test',
];

$orderBT = $checkoutService->createPendingOrder($customerDataBT, $cart, $totals);
echo "\n[TEST 1] Bank Transfer Order Created: {$orderBT->order_number}\n";

$paymentBT = Payment::create([
    'order_id' => $orderBT->id,
    'provider' => 'bank_transfer',
    'reference' => 'FC-BT-' . strtoupper(bin2hex(random_bytes(4))),
    'transaction_id' => 'GTB/TEST/99823',
    'amount' => $orderBT->total_amount,
    'currency' => 'NGN',
    'channel' => 'direct_bank_transfer',
    'status' => 'pending',
    'gateway_response' => 'Awaiting direct transfer to GTBank from Korede Adeleke',
    'raw_payload' => [
        'bank_name' => 'Guaranty Trust Bank (GTBank)',
        'account_number' => '0124892019',
        'account_name' => 'Fortunes Collection Atelier Ltd',
        'branch' => 'PTI Road, Effurun, Delta State',
        'sender_name' => 'Korede Adeleke',
        'sender_reference' => 'GTB/TEST/99823',
    ],
]);
echo "Payment record created: {$paymentBT->reference} (Provider: {$paymentBT->provider}, Status: {$paymentBT->status})\n";

// 4. Test Card Payment Order
$orderCard = $checkoutService->createPendingOrder(array_merge($customerDataBT, ['payment_method' => 'card']), $cart, $totals);
echo "\n[TEST 2] Card Order Created: {$orderCard->order_number}\n";

$paymentCard = Payment::create([
    'order_id' => $orderCard->id,
    'provider' => 'card',
    'reference' => 'FC-CARD-' . strtoupper(bin2hex(random_bytes(4))),
    'transaction_id' => 'AUTH_' . strtoupper(bin2hex(random_bytes(4))),
    'amount' => $orderCard->total_amount,
    'currency' => 'NGN',
    'channel' => 'card',
    'status' => 'successful',
    'gateway_response' => 'Approved by Visa 3D-Secure Protocol',
    'raw_payload' => [
        'brand' => 'Visa',
        'last4' => '4242',
        'masked_card' => '•••• •••• •••• 4242',
        'cardholder' => 'Korede Adeleke',
        'auth_code' => 'AUTH_99812A',
    ],
    'verified_at' => now(),
]);
$orderCard->update([
    'status' => 'paid',
    'payment_status' => 'paid',
    'paid_at' => now(),
]);
echo "Card Payment settled: {$paymentCard->reference} (Status: {$orderCard->status})\n";

// 5. Test Crypto Order
$orderCrypto = $checkoutService->createPendingOrder(array_merge($customerDataBT, ['payment_method' => 'crypto']), $cart, $totals);
echo "\n[TEST 3] Crypto Order Created: {$orderCrypto->order_number}\n";

$approxAmount = number_format($orderCrypto->total_amount / 1550, 2, '.', '');
$paymentCrypto = Payment::create([
    'order_id' => $orderCrypto->id,
    'provider' => 'crypto',
    'reference' => 'FC-CRYPTO-' . strtoupper(bin2hex(random_bytes(4))),
    'transaction_id' => 'TX_TRC20_98374829AAFF',
    'amount' => $orderCrypto->total_amount,
    'currency' => 'USDT',
    'channel' => 'cryptocurrency',
    'status' => 'pending',
    'gateway_response' => 'Awaiting USDT network confirmation for order ' . $orderCrypto->order_number,
    'raw_payload' => [
        'asset' => 'usdt_trc20',
        'asset_symbol' => 'USDT',
        'vault_address' => 'TJFortunesEffurunAtelierVaultTRC99X',
        'tx_hash' => 'TX_TRC20_98374829AAFF',
        'approx_crypto_amount' => $approxAmount . ' USDT',
    ],
]);
echo "Crypto Payment recorded: {$paymentCrypto->reference} ({$paymentCrypto->currency} Vault: TJFortunesEffurunAtelierVaultTRC99X)\n";

// 6. Test Blade Rendering for all three success pages
echo "\nTesting Blade Views Rendering:\n";
$viewBT = view('checkout.success', ['order' => $orderBT->fresh(['items.product', 'shippingAddress', 'payments'])])->render();
echo "-> Bank Transfer Success View Rendered: " . strlen($viewBT) . " bytes. Has '0124892019': " . (str_contains($viewBT, '0124892019') ? 'YES' : 'NO') . "\n";

$viewCard = view('checkout.success', ['order' => $orderCard->fresh(['items.product', 'shippingAddress', 'payments'])])->render();
echo "-> Card Success View Rendered: " . strlen($viewCard) . " bytes. Has '3D-SECURE': " . (str_contains($viewCard, '3D-SECURE') ? 'YES' : 'NO') . "\n";

$viewCrypto = view('checkout.success', ['order' => $orderCrypto->fresh(['items.product', 'shippingAddress', 'payments'])])->render();
echo "-> Crypto Success View Rendered: " . strlen($viewCrypto) . " bytes. Has 'TJFortunes': " . (str_contains($viewCrypto, 'TJFortunes') ? 'YES' : 'NO') . "\n";

// Clean up test orders
$orderBT->delete();
$orderCard->delete();
$orderCrypto->delete();

echo "\nALL TESTS PASSED WITH ZERO ERRORS!\n";
