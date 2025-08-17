<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['product_type_id']);

            // Opsional: kalau mau field-nya tetap ada tapi jadi nullable
            $table->unsignedBigInteger('product_type_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_type_id')->change(); // kembalikan ke non-nullable jika awalnya begitu
            $table->foreign('product_type_id')->references('id')->on('product_types');
        });
    }
};
