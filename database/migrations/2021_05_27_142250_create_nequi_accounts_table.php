<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNequiAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nequi_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->string('name');
            $table->string('document_number');
            $table->string('phone');
            $table->string('status')->comment('0 = Inactivo, 1 = Activo, 2 = Principal');
            $table->string('state')->default('1')->comment('0 = deshabilitada, 1 = habilitada');
            $table->string('automatic_debit_token');
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
        Schema::dropIfExists('nequi_accounts');
    }
}
