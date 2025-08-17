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
        Schema::create('credit_calculator_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_calculator_id');
            $table->string('ip_address');
            $table->timestamps();

            $table->foreign('credit_calculator_id')->references('id')->on('credit_calculators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_calculator_visits');
    }
};