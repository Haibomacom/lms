<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_borrow', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('location_id');
            $table->string('trade_number');
            $table->text('payment');
            $table->text('result')->nullable();
            $table->text('transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('borrowed_at')->nullable();
            $table->timestamp('restored_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('trade_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_borrow');
    }
}
