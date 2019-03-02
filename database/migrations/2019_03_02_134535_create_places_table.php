<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('dispo');
        });

        //table pivot ou avec cle primaire composée de 3 id dont la date pour remplacer la ternaire avec la table date
        Schema::create('place_user', function (Blueprint $table){
            $table->integer('place_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('date');
            $table->integer('duree')->unsigned()->default(2);
            $table->primary(['place_id','user_id','date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_user');
        Schema::dropIfExists('places');
    }
}
