<?php

namespace App\Http\Controllers;

use App\Services\Payment\PaystackService;
use App\Services\Payment\FlutterwaveService;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function __construct(
        protected PaystackService $paystackService,
        protected FlutterwaveService $flutterwaveService
    ) {}

    /**
     * Handle Paystack Webhooks with HMAC-SHA512 signature authentication.
     */
    public function paystack(Request $request): JsonResponse
    {
        $signature = $request->header('x-paystack-signature');
        $rawPayload = $request->getContent();

        if (!$this->paystackService->validateWebhookSignature($rawPayload, $signature)) {
            Log::warning('Paystack webhook invalid signature attempt', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        if ($event === 'charge.success') {
            $reference = $data['reference'] ?? null;
            if ($reference) {
                $payment = Payment::where('reference', $reference)->first();
                if ($payment && $payment->status !== 'successful') {
                    $order = $payment->order;
                    $this->paystackService->processSuccessfulPayment($order, $payment, [
                        'channel' => $data['channel'] ?? 'card',
                        'transaction_id' => (string) ($data['id'] ?? ''),
                        'gateway_response' => $data['gateway_response'] ?? 'Successful',
                        'raw' => $data,
                    ]);
                    Log::info("Paystack webhook processed payment for Order {$order->order_number}");
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Handle Flutterwave Webhooks with verif-hash validation.
     */
    public function flutterwave(Request $request): JsonResponse
    {
        $signature = $request->header('verif-hash');

        if (!$this->flutterwaveService->validateWebhookSignature($signature)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $data = $request->input('data');
        if (($data['status'] ?? '') === 'successful') {
            $txRef = $data['tx_ref'] ?? null;
            if ($txRef) {
                $payment = Payment::where('reference', $txRef)->first();
                if ($payment && $payment->status !== 'successful') {
                    $order = $payment->order;
                    $this->paystackService->processSuccessfulPayment($order, $payment, [
                        'channel' => $data['payment_type'] ?? 'card',
                        'transaction_id' => (string) ($data['id'] ?? ''),
                        'gateway_response' => 'Successful',
                        'raw' => $data,
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
