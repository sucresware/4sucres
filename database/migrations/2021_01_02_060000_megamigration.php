<?php

use App\Models\Board;
use App\Models\Thread;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Megamigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('oauth_access_tokens');
        Schema::drop('oauth_auth_codes');
        Schema::drop('oauth_clients');
        Schema::drop('oauth_personal_access_clients');
        Schema::drop('oauth_refresh_tokens');

        Schema::rename('discussions', 'threads');
        Schema::rename('categories', 'boards');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('api_token');
        });

        Schema::table('threads', function (Blueprint $table) {
            $table->renameColumn('board_id', 'board_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('thread_id', 'thread_id');
        });

        Schema::table('boards', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->longText('description')->after('name')->nullable();
        });

        Board::where('slug', 'annonces')->update(['slug' => 'mod', 'name' => 'Annonces', 'description' => 'Annonces de la plateforme et de la modération']);
        Board::where('slug', 'general')->update(['slug' => 'random', 'name' => 'Random', 'description' => 'Tout ce qui ne correspond à aucune autre board']);
        Board::where('slug', 'jeux')->update(['slug' => 'games', 'name' => 'Jeux', 'description' => 'thread sur les jeux vidéos']);
        Board::where('slug', 'nsfw')->update(['slug' => 'nsfw', 'name' => 'NSFW']);
        Board::where('slug', 'tech')->update(['slug' => 'dev', 'name' => 'Développement']);
        Board::where('slug', 'anime')->update(['slug' => 'anime', 'name' => 'Anime & Manga']);
        Board::where('slug', 'pol')->update(['slug' => 'pol', 'name' => 'Politiquement incorrect']);

        $merge_in_random = [
            Board::where('slug', 'lifehacks')->first(),
            Board::where('slug', 'shitpost')->first(),
            Board::where('slug', 'partage-vidéo')->first(),
            Board::where('slug', 'olinux')->first(),
        ];

        $random_board_id = Board::where('slug', 'random')->first()->id;
        foreach ($merge_in_random as $board) {
            Thread::where('board_id', $board->id)->update(['board_id' => $random_board_id]);
            $board->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
