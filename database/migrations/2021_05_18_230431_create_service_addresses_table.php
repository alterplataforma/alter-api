<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_addres_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });


        Schema::create('service_addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_service')->nullable();
            $table->foreign('id_service')->references('id')->on('services');

            $table->unsignedInteger('id_city')->nullable();
            $table->foreign('id_city')->references('id')->on('cities');

            $table->unsignedInteger('id_service_addres_order')->nullable();
            $table->foreign('id_service_addres_order')->references('id')->on('service_addres_orders');

            $table->string('address');
            $table->string('indications')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('estimated_time')->nullable()->comment('tiempo estimado del servicio');

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
        Schema::dropIfExists('service_addres_orders');
        Schema::dropIfExists('service_addresses');
    }
}
