<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDiscussionsTable extends Migration
{
    public function up()
    {
        Schema::create('users_discussions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('discussion_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('users_discussions');
    }
}
