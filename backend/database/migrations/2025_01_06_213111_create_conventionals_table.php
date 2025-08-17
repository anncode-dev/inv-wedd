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
        Schema::create('conventionals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            //$table->enum('type', ['1', '2','3','4']);
            $table->text('name');
            $table->text('file')->nullable();
            $table->boolean('is_active')->default(true);      
            
            $table->foreignId('information_category_id')->constrained()->cascadeOnDelete();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conventionals');
    }
};
