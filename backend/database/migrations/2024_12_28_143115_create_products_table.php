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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->foreignId('type_website_id')->constrained()->cascadeOnDelete();            
            $table->foreignId('product_type_id')->constrained()->cascadeOnDelete();            
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
