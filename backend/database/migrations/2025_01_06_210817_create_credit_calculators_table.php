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
        Schema::create('credit_calculators', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->enum('type', ['KBR', 'KBP','KUR','KMG']);
            $table->string('month_year')->nullable();
            $table->text('periods')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_calculators');
    }
};
