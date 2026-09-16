<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('details')->nullable();
            $table->text('care_instructions')->nullable();
            $table->text('size_guide')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('compare_at_price', 12, 2)->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('collection_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_new')->default(true)->index();
            $table->boolean('is_bestseller')->default(false)->index();
            $table->string('status')->default('active')->index(); // active, draft, archived
            $table->string('featured_image')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('size')->nullable(); // XS, S, M, L, XL, XXL, O/S
            $table->string('color')->nullable(); // Obsidian Noir, Royal Gold, Cyber Olive
            $table->string('color_hex')->nullable(); // #0A0A0A, #D4AF37
            $table->string('sku')->unique();
            $table->decimal('price_override', 12, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
    }
};
