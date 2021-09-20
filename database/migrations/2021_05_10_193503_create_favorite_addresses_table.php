<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');

            $table->string('status')->default('1')->nullable()->comment('0 = desactivada, 1 = activa');
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('id_city')->nullable();
            $table->foreign('id_city')->references('id')->on('cities');
            $table->string('indications')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

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
        Schema::dropIfExists('favorite_addresses');
    }
}
