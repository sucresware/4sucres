<?php

use App\Models\VerifyUser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScopeToVerifyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verify_users', function (Blueprint $table) {
            $table->integer('scope')->default(VerifyUser::SCOPE_VERIFY_EMAIL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verify_users', function (Blueprint $table) {
            //
        });
    }
}
