<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_state', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state');
            $table->string('status')->default('1');

            $table->timestamps();
        });

        Schema::create('cash_retirement', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedInteger('id_state');
            $table->foreign('id_state')->references('id')->on('cash_state');

            $table->string('value');
            $table->string('ip');
            $table->string('status')->default('1');
            $table->timestamps();
        });

        Schema::create('cash_shipping', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_user_shipping')->comment('usuario quien envia el dinero');
            $table->foreign('id_user_shipping')->references('id')->on('users');

            $table->unsignedInteger('id_user_receive')->comment('usuario a quien le envian el dinero');
            $table->foreign('id_user_receive')->references('id')->on('users');

            $table->string('ip');
            $table->string('value');
            $table->string('status')->default('1');

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
        Schema::dropIfExists('cash_retirement');
        Schema::dropIfExists('cash_shipping');
        Schema::dropIfExists('cash_state');
    }
}
