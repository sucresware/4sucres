<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeColumnsToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('restricted');
            $table->json('can_post')->nullable();
            $table->json('can_view')->nullable();
            $table->boolean('nsfw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('restricted')->default(false);
        });

        foreach (Category::get() as $category) {
            if ($category->can_post != null) {
                $category->restricted = true;
                $category->save();
            }
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('can_post');
            $table->dropColumn('can_view');
            $table->dropColumn('nsfw');
        });
    }
}
