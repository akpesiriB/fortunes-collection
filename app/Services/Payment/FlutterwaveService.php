<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwaveService
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $secretHash;

    public function __construct()
    {
        $this->secretKey = (string) config('services.flutterwave.secret_key', '');
        $this->publicKey = (string) config('services.flutterwave.public_key', '');
        $this->secretHash = (string) config('services.flutterwave.secret_hash', '');
    }

    public function initializeTransaction(Order $order, string $callbackUrl): array
    {
        $txRef = 'FLW_' . $order->order_number . '_' . bin2hex(random_bytes(4));

        Payment::create([
            'order_id' => $order->id,
            'provider' => 'flutterwave',
            'reference' => $txRef,
            'amount' => $order->total_amount,
            'currency' => 'NGN',
            'status' => 'pending',
        ]);

        $demoVerifyUrl = route('checkout.simulate.paystack', ['reference' => $txRef, 'provider' => 'flutterwave']);

        return [
            'success' => true,
            'authorization_url' => $demoVerifyUrl,
            'reference' => $txRef,
            'is_simulation' => true,
        ];
    }

    public function validateWebhookSignature(?string $verifHashHeader): bool
    {
        if (empty($this->secretHash) || empty($verifHashHeader)) {
            return false;
        }

        return hash_equals($this->secretHash, $verifHashHeader);
    }
}
