<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->string('recipient_name');
            $table->string('email');
            $table->string('phone');
            $table->string('street_address');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('state'); // Delta, Edo, Rivers, etc.
            $table->string('lga')->nullable(); // Eti-Osa, Ikeja, etc.
            $table->string('country')->default('Nigeria');
            $table->string('postal_code')->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
