<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle');

            $table->unsignedInteger('id_vehicle_type')->nullable();
            $table->foreign('id_vehicle_type')->references('id')->on('vehicle_types');

            $table->unsignedInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');

            $table->string('plate')->nullable();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chasis_number')->nullable();
            $table->string('image_registration_front')->nullable()->comment('imagen de matricula frontal');
            $table->string('image_registration_back')->nullable();
            $table->string('expiration_date_soat')->nullable()->comment('fecha de vencimiento soat');
            $table->string('expiration_date_tecnico')->nullable()->comment('fecha de vencimiento tecnicomecanica');
            $table->string('proprietor_document_number')->nullable()->comment('numero de documento del propitario');
            $table->string('proprietor_name')->nullable()->comment('nombre del propitario');

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
        Schema::dropIfExists('vehicles');
    }
}
