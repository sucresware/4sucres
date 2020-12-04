<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRareColumnToAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->boolean('rare')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('rare');
        });
    }
}
