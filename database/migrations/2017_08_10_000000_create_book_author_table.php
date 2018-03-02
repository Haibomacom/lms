<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_author', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name_cn');
            $table->text('name_en')->nullable();
            $table->unsignedTinyInteger('gender')->default(0);
            $table->text('intro')->nullable();
            $table->date('birth_time')->nullable();
            $table->date('death_time')->nullable();
            $table->text('birthplace')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_author');
    }
}
