<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeletesToProfileCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('profile_categories', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('profile_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
