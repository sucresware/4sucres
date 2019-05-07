<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class');
            $table->string('text');
            $table->text('href');
            $table->boolean('seen')->default(false);
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('notifications');
    }
}
