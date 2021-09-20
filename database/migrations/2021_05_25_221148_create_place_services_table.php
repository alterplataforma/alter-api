<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_places', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_service')->nullable();
            $table->foreign('id_service')->references('id')->on('services');

            $table->unsignedInteger('id_place')->nullable();
            $table->foreign('id_place')->references('id')->on('places');
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
        Schema::dropIfExists('service_places');
    }
}
