<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 64);
            $table->string('unionid', 64)->nullable();
            $table->string('session', 64)->nullable();
            $table->unsignedTinyInteger('role')->default(1);
            $table->string('mobile', 20)->nullable();
            $table->unsignedTinyInteger('mobile_verify')->default(0);
            $table->string('password', 64)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('openid');
            $table->index('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
}
