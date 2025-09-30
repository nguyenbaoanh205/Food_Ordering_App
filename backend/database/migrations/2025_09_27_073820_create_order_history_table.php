<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('status', 20);
            $table->timestamps(); // Tạo cột created_at và updated_at tự động
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_history');
    }
};
