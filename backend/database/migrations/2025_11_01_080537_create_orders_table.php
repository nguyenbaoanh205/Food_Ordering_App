<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_address')->nullable();
            $table->text('note')->nullable()->comment('Ghi chú của khách hàng khi đặt hàng');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pending','confirmed','completed','cancelled'])->default('pending');
            $table->enum('payment_method', ['cash','credit_card','paypal','momo','stripe'])->default('cash');
            $table->enum('payment_status', ['unpaid','paid','refunded'])->default('unpaid');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
