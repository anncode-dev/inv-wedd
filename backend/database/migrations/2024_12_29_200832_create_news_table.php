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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('title',50);
            $table->string('type',1);            
            $table->text('image')->nullable();          
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();   
            $table->boolean('is_active')->default(0);      
            $table->foreignId('type_website_id')->nullable()->constrained()->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
