<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('food_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete();
            $table->string('name', 100);
            $table->decimal('extra_price', 10, 2)->default(0.00);
            $table->enum('type', ['size', 'topping'])->default('topping');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('food_options');
    }
};
