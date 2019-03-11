<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('firstname');
            $table->string('adresse');
            $table->string('city');
            $table->string('postal_code');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            //utilisateur ou admin
            $table->string('rules')->default('utilisateur');
            $table->string('password');
            //0 = ok, 1 = to valid,
            $table->tinyInteger('tovalid')->default(1);
            $table->integer('rang')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
