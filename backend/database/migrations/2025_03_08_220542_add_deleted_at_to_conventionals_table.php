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
        Schema::table('conventionals', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('syariahs', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('product_categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('about_us', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('about_us_details', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('corporate_governance_categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('corporate_governances', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conventionals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('syariahs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('about_us_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('corporate_governance_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('corporate_governances', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
