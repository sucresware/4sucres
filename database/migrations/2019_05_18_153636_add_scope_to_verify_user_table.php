<?php

use App\Models\VerifyUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScopeToVerifyUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('verify_users', function (Blueprint $table) {
            $table->integer('scope')->default(VerifyUser::SCOPE_VERIFY_EMAIL);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('verify_users', function (Blueprint $table) {
        });
    }
}
