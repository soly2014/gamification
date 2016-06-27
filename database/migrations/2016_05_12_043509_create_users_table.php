<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['student', 'teacher']);    
            $table->string('email')->unique();
            $table->string('referral_code')->unique();
            $table->string('image_name');
            $table->string('facebook_id')->default(0);
            $table->string('twitter_id')->default(0);
            $table->string('invited_by')->default(0);
            $table->integer('phone');
            $table->boolean('shared');  
            $table->string('country');  
            $table->string('handle');  
            $table->boolean('tweeted'); 
            $table->boolean('shared_photo');    
            $table->string('password', 60);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
