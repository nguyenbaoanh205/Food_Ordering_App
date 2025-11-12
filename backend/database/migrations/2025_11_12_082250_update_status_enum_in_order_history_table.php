<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm các trạng thái mới vào cột status
        DB::statement("
            ALTER TABLE order_history 
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'preparing',
                'shipping',
                'delivered',
                'completed',
                'cancelled'
            ) NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Quay về enum cũ nếu rollback
        DB::statement("
            ALTER TABLE order_history 
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'completed',
                'cancelled'
            ) NOT NULL
        ");
    }
};
