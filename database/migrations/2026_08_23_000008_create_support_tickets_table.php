<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('category'); // Order Query, Payment Problem, Delivery Query, Cancellation/Return, General
            $table->string('subject');
            $table->text('description');
            $table->string('priority')->default('Normal'); // Low, Normal, High, Urgent
            $table->string('status')->default('Open'); // Open, In Progress, Answered, Resolved, Closed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
