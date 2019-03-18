<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Table pivot ou avec cle primaire composée de 3 id dont la date pour remplacer la ternaire avec la table date
        Schema::create('reservations', function (Blueprint $table){
            $table->increments('id');
            $table->integer('place_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->timestamp('date_debut')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->smallInteger('duree')->default(2);
            //pour gere si une resa est annuléee ou pas 
            $table->boolean('is_cancelled')->default(false);
            ; 

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
