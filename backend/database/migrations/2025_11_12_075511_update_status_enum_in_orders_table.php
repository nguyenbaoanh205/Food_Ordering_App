<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ⚠️ Cần dùng raw SQL vì enum không thể sửa trực tiếp bằng Schema builder
        DB::statement("
            ALTER TABLE orders
            MODIFY COLUMN status ENUM(
                'pending',
                'confirmed',
                'preparing',
                'shipping',
                'delivered',
                'completed',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        // Rollback về trạng thái ban đầu
        DB::statement("
            ALTER TABLE orders
            MODIFY COLUMN status ENUM(
                'pending',
                'confirmed',
                'completed',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }
};
