<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAchievementTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_achievement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('achievement_id');
            $table->timestamp('unlocked_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_achievement');
    }
}
