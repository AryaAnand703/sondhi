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
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('bulk_price', 10, 2)->nullable();
            $table->integer('bulk_min_qty')->default(50);
            $table->integer('stock_quantity')->default(100);
            $table->string('image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active'); // active, draft
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
