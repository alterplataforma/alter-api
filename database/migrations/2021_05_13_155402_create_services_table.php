<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_service_type')->nullable();
            $table->foreign('id_service_type')->references('id')->on('service_types');

            $table->unsignedInteger('id_vehicle')->nullable();
            $table->foreign('id_vehicle')->references('id')->on('vehicles');

            $table->unsignedInteger('id_payment_type')->nullable();
            $table->foreign('id_payment_type')->references('id')->on('payment_types');

            $table->unsignedInteger('id_client')->nullable()->comment('cliente que pide el servicio');
            $table->foreign('id_client')->references('id')->on('users');

            $table->unsignedInteger('id_provider')->nullable()->comment('el id domiciliario');
            $table->foreign('id_provider')->references('id')->on('users');

            $table->unsignedInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('service_states');

            $table->string('incluyetramite')->nullable();
            $table->string('for_cancel')->nullable()->comment('causa de cancelación');
            $table->string('arrival_date')->nullable()->comment('fecha de llegada del servicio');
            $table->string('finish_date')->nullable()->comment('fecha de llegada terminación');
            $table->string('estimated_time')->nullable()->comment('tiempo estimado del servicio');
            $table->string('Time_for_repair')->nullable()->comment('tiempo estimado de repación');
            $table->double('value')->nullable();
            $table->double('total')->nullable();
            $table->double('estimated_total')->nullable()->comment('valor total aproximado');
            $table->string('transaction')->nullable();
            $table->string('reference_nequi')->nullable();
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
        Schema::dropIfExists('services');
    }
}
