<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->unsignedInteger('id_place_type')->nullable();
            $table->foreign('id_place_type')->references('id')->on('place_types');

            $table->unsignedInteger('id_city')->nullable();
            $table->foreign('id_city')->references('id')->on('cities');

            $table->unsignedInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('1');
            $table->string('approved')->nullable();
            $table->string('address')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('headquarter')->nullable()->comment('0 = Sede 1 = Sede Principal');
            $table->string('register_type')->nullable()->comment('1 = App 2 = Scraping');
            $table->string('product_charge')->nullable()->comment('por cobro producto');
            $table->string('proprietor_name')->nullable()->comment('nombre de propietario');
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
        Schema::dropIfExists('places');
    }
}
