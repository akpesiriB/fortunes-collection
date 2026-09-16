<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Shipping Methods
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_cost', 12, 2)->default(0.00);
            $table->decimal('cost_per_kg', 12, 2)->default(0.00);
            $table->decimal('free_shipping_min_amount', 12, 2)->nullable();
            $table->string('estimated_delivery_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Persistent Shopping Carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->string('coupon_code')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->string('status')->default('active'); // active, abandoned, converted
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });

        // 3. Cart Items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        // 4. Order Status Timeline / Tracking History
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('status'); // pending, paid, processing, shipped, delivered, cancelled
            $table->text('notes')->nullable();
            $table->boolean('notified_customer')->default(false);
            $table->string('action_by')->default('system'); // system, admin, customer, gateway
            $table->timestamps();
        });

        // 5. Refunds & RMA Requests
        Schema::create('refund_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('reason');
            $table->text('details')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, refunded
            $table->text('admin_response')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        // 6. Product Tags & Categorization
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('general'); // badge, material, style, featured
            $table->timestamps();
        });

        Schema::create('product_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['product_id', 'tag_id']);
        });

        // 7. Newsletter Subscribers & VIP Club
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('status')->default('subscribed'); // subscribed, unsubscribed
            $table->string('source')->default('storefront'); // footer, checkout, modal
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamps();
        });

        // 8. Contact & Concierge Support Inquiries
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('unread'); // unread, in_progress, resolved
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 9. Admin Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')->nullable()->constrained('admin_users')->nullOnDelete();
            $table->string('action'); // product_created, order_updated, price_adjusted, coupon_issued
            $table->string('entity_type')->nullable(); // Product, Order, Coupon, User
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('refund_requests');
        Schema::dropIfExists('order_histories');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('shipping_methods');
    }
};
