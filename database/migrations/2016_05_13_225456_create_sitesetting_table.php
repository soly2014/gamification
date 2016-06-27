<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 
    public function up()
    {
        Schema::create('sitesettings', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('homeone');
            $table->longText('hometwo');
            $table->longText('homethree');
            $table->longText('homefour');
            $table->longText('homefive');
            $table->longText('featureone');
            $table->longText('featuretwo');
            $table->longText('featurethree');
            $table->longText('featurefour');
            $table->longText('featurefive');
            $table->longText('profileone');
            $table->longText('profiletwo');
            $table->longText('profilethree');
            $table->longText('profilefour');

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
        Schema::drop('sitesettings');
    }
}
