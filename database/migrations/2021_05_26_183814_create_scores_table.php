<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('score')->nullable();
            $table->string('comments')->nullable();
            $table->string('type_user')->nullable();

            $table->unsignedInteger('id_user')->nullable()->comment('el usuario que hace la calificación');
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedInteger('id_calificado')->nullable()->comment('el usuario que califican');
            $table->foreign('id_calificado')->references('id')->on('users');

            $table->unsignedInteger('id_service')->nullable();
            $table->foreign('id_service')->references('id')->on('services');

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
        Schema::dropIfExists('scores');
    }
}
