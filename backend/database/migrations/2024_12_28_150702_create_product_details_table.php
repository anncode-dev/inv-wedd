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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('menu',20);
            $table->text('title');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('url_download')->nullable();

            $table->foreignId('product_id')->constrained()->cascadeOnDelete();                        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
