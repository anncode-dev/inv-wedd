<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unit_teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title', 100);
            $table->string('short_description')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('units')->nullable();
        });

        // Insert default data
        DB::table('unit_teams')->insert([
            [
                'title' => 'Development Team',
                'short_description' => 'Handles all software development tasks.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Marketing Team',
                'short_description' => 'Focuses on marketing and promotions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Support Team',
                'short_description' => 'Provides customer support services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_teams');
    }
};
