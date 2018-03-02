<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->text('title');
            $table->unsignedInteger('author_id');
            $table->text('img');
            $table->text('isbn');
            $table->text('publish_house')->nullable();
            $table->text('publish_time')->nullable();
            $table->text('object')->nullable();
            $table->text('intro')->nullable();
            $table->text('douban_id')->nullable();
            $table->text('douban_price')->nullable();
            $table->unsignedInteger('favorite_number')->default(0);
            $table->unsignedInteger('borrow_number')->default(0);
            $table->unsignedInteger('view_number')->default(0);
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
        Schema::dropIfExists('book_info');
    }
}
