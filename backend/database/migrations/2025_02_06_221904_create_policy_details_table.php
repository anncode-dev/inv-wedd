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
        Schema::create('policy_details', function (Blueprint $table) {            
            $table->id();
            $table->timestamps();

            $table->text('menu',20);
            $table->text('title');            
            $table->text('description')->nullable();
            
            $table->foreignId('policies_id')->constrained()->cascadeOnDelete();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_details');
    }
};
