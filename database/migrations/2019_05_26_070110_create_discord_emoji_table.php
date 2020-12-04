<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordEmojiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('discord_emoji', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('discord_guild_id');
            $table->string('name');
            $table->boolean('animated');
            $table->boolean('deleted');
            $table->boolean('require_colons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('discord_emoji');
    }
}
