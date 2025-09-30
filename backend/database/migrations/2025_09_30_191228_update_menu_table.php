<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuTable extends Migration
{
    public function up()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('category'); // Xóa trường category cũ
            $table->foreignId('category_id')->nullable()->constrained()->after('price')->onDelete('set null'); // Thêm trường category_id
            $table->string('image_url')->nullable()->after('category_id'); // Thêm trường image_url
        });
    }

    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->string('category', 50)->nullable()->after('price'); // Khôi phục trường category cũ
            $table->dropForeign(['category_id']); // Xóa khóa ngoại
            $table->dropColumn('category_id'); // Xóa trường category_id
            $table->dropColumn('image_url'); // Xóa trường image_url
        });
    }
}

