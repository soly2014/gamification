<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaycloudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payclouds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_id');
            $table->string('payer_id');
            $table->string('payer_email');
            $table->boolean('refunded');
            $table->timestamps();
            $table->integer('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payclouds');
    }
}
