<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // Floral, Warm, Earthy, Fresh, Woody
            $table->string('fragrance');
            $table->string('top_notes')->nullable();
            $table->string('heart_notes')->nullable();
            $table->string('base_notes')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->integer('reviews_count')->default(0);
            $table->string('burn_time')->default('50 Hours');
            $table->string('weight')->default('280g');
            $table->string('badge')->nullable(); // Bestseller, Limited Reserve, Essential, etc.
            $table->text('image');
            $table->text('description');
            $table->integer('stock')->default(50);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('status')->default('Pending');
            $table->string('status_code')->default('pending'); // pending, pouring, dispatched, delivered, cancelled
            $table->text('status_desc')->nullable();
            $table->integer('items_count')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('estimated_delivery')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('payment_method')->default('card');
            $table->timestamps();
        });

        // 3. Order Items Table
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // 4. Saved Addresses Table
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label')->default('Home');
            $table->string('street');
            $table->string('city');
            $table->string('pincode');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // 5. Bespoke Formulas Table
        Schema::create('bespoke_formulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('vessel');
            $table->string('wick');
            $table->string('top');
            $table->string('heart');
            $table->string('base');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 6. Discounts & Promo Codes Table
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type')->default('percent'); // percent or fixed
            $table->decimal('value', 10, 2);
            $table->decimal('min_spend', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Audit Logs Table
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->text('details')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('bespoke_formulas');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
