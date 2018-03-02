<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_log', function (Blueprint $table) {
            $table->string('mobile', 20);
            $table->string('code', 10);
            $table->unsignedTinyInteger('status');
            $table->text('result');
            $table->timestamps();

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
        Schema::dropIfExists('sms_log');
    }
}
