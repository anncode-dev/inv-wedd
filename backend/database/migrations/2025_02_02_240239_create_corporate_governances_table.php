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
        Schema::create('corporate_governances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('category',2)->nullable();
            $table->string('month')->nullable();            
            $table->string('file')->nullable();

            $table->foreignId('corporate_governance_category_id')->constrained()->cascadeOnDelete();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_governances');
    }
};
