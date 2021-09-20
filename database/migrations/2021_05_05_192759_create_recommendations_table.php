<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_recomendado')->nullable()->comment('el id del usuario que lo recomendó');
            $table->foreign('id_recomendado')->references('id')->on('users');

            $table->unsignedInteger('id_user')->nullable()->comment('el id del usuario que recomiendan');
            $table->foreign('id_user')->references('id')->on('users');

            $table->string('status')->default('1')->nullable()->comment('0 = No registrado, 1 = Registrado, 2 = Cancelado (para el efecto de que una persona nunca se registre o dure mucho tiempo para hacerlo el usuario tiene la opcion de eliminarlo de sus recomendados)');

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
        Schema::dropIfExists('recommendations');
    }
}
