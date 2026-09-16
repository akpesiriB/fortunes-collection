<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Inventory;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\Payment\PaystackService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FortunesCommerceTest extends TestCase
{
    /**
     * Test Homepage renders with luxury aesthetic, ticker, and catalog items.
     */
    public function test_homepage_renders_with_luxury_hero_and_products(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('FORTUNES COLLECTION');
        $response->assertSee('HOT SERIES');
        $response->assertSee('FASTEST-SELLING BRANDS');
        $response->assertSee('EFFURUN');
    }

    /**
     * Test Catalog page renders with products and categories.
     */
    public function test_catalog_page_renders_with_categories_and_filters(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('THE FULL ARCHIVE');
        $response->assertSee('TOPS');
        $response->assertSee('BOTTOMS');
    }

    /**
     * Test Hot Series brand collection filtering in catalog.
     */
    public function test_catalog_filters_by_hot_series_collection(): void
    {
        $collection = \App\Models\Collection::first();
        $this->assertNotNull($collection);

        $response = $this->get('/shop?collection=' . $collection->slug);
        $response->assertStatus(200);
        $response->assertSee('HOT SERIES');
        $response->assertSee($collection->name);
    }

    /**
     * Test Product Detail page displays pricing, variants, and structured schema.
     */
    public function test_product_detail_page_renders_with_price_and_variants(): void
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->get("/product/{$product->slug}");
        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->formatted_price);
        $response->assertSee('schema.org');
        $response->assertSee('NGN');
    }

    /**
     * Test Cart service calculates prices strictly server-side from database.
     */
    public function test_cart_service_calculates_prices_strictly_server_side(): void
    {
        $product = Product::first();
        $cartService = app(CartService::class);

        $cartService->addItem($product->id, $product->variants->first()?->id, 2);
        $cart = $cartService->getCart();

        $this->assertEquals(2, $cart['total_quantity']);
        $this->assertGreaterThan(0, $cart['subtotal']);
        $this->assertEquals($cart['subtotal'], $cart['items'][$product->id . '_' . ($product->variants->first()?->id ?? '0')]['subtotal']);

        $cartService->clear();
    }

    /**
     * Test Checkout calculation of Nigerian shipping rates and free delivery threshold.
     */
    public function test_checkout_calculates_nigerian_shipping_and_totals(): void
    {
        $checkoutService = app(CheckoutService::class);

        // Under ₦500,000 threshold
        $cartStandard = ['subtotal' => 200000.00];
        $totalsStandard = $checkoutService->calculateTotals($cartStandard, 'effurun_vip', null);
        $this->assertEquals(2500.00, $totalsStandard['shipping_fee']);
        $this->assertEquals(202500.00, $totalsStandard['total_amount']);

        // Over ₦500,000 threshold -> complimentary shipping
        $cartVip = ['subtotal' => 600000.00];
        $totalsVip = $checkoutService->calculateTotals($cartVip, 'effurun_vip', null);
        $this->assertEquals(0.0, $totalsVip['shipping_fee']);
        $this->assertEquals(600000.00, $totalsVip['total_amount']);
    }

    /**
     * Test Paystack transaction initialization and verification workflow.
     */
    public function test_paystack_payment_initialization_and_verification(): void
    {
        $order = Order::first();
        $this->assertNotNull($order);

        $paystackService = app(PaystackService::class);
        $initResult = $paystackService->initializeTransaction($order, 'http://localhost:8000/callback');

        $this->assertTrue($initResult['success']);
        $this->assertNotEmpty($initResult['reference']);

        // Verify transaction
        $verifyResult = $paystackService->verifyTransaction($initResult['reference']);
        $this->assertTrue($verifyResult['success']);
    }

    /**
     * Test Paystack HMAC-SHA512 webhook signature validation.
     */
    public function test_paystack_webhook_hmac_sha512_verification(): void
    {
        $secretKey = config('services.paystack.secret_key');
        $payload = json_encode(['event' => 'charge.success', 'data' => ['reference' => 'TEST_REF']]);
        $validSignature = hash_hmac('sha512', $payload, $secretKey);

        $paystackService = app(PaystackService::class);

        $this->assertTrue($paystackService->validateWebhookSignature($payload, $validSignature));
        $this->assertFalse($paystackService->validateWebhookSignature($payload, 'invalid_signature'));
    }

    /**
     * Test Customer Isolation Policy: Customer A cannot view Customer B's order.
     */
    public function test_customer_cannot_access_other_customer_orders(): void
    {
        $customerA = User::first();
        $otherCustomer = User::create([
            'name' => 'Stranger',
            'email' => 'stranger_' . uniqid() . '@example.com',
            'password' => 'secret123',
        ]);

        $orderA = Order::where('user_id', $customerA->id)->first();
        $this->assertNotNull($orderA);

        // Stranger attempts to view Customer A's order
        $response = $this->actingAs($otherCustomer, 'web')
            ->get("/account/orders/{$orderA->order_number}");

        $response->assertStatus(404); // Isolated via firstOrFail with user_id match
    }

    /**
     * Test Admin routes are protected and command center loads for authenticated director.
     */
    public function test_admin_dashboard_metrics_and_protected_routes(): void
    {
        // Unauthenticated access redirects to login
        $guestResponse = $this->get('/admin');
        $guestResponse->assertRedirect('/admin/login');

        // Authenticated Admin access
        $admin = AdminUser::first();
        $this->assertNotNull($admin);

        $adminResponse = $this->actingAs($admin, 'admin')->get('/admin');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('COMMAND OVERVIEW');
        $adminResponse->assertSee('Total Archive Revenue');
    }
}
