<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            //supprime en cascade les places requests si jamais l'user n'existe plus
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->smallInteger('etat')->default(0);
            $table->integer('rang')->default(0);
            ;
            $table->timestamp('date_demande');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_requests');
    }
}
