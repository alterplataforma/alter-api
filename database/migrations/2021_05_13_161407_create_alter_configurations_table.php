<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alter_configurations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('minimum_payment')->nullable()->comment('pago minimo');
            $table->integer('charge_meters')->nullable()->comment('metros cobro');
            $table->integer('accept_time')->nullable()->comment('tiempo para aceptar');
            $table->integer('processing_value')->nullable()->comment('valor de tramite');
            $table->integer('provider_search_time')->nullable()->comment('tiempo de busqueda de proveedor');
            $table->double('first_level_contribution')->nullable()->comment('aporte primer nivel');
            $table->double('second_level_contribution')->nullable()->comment();
            $table->double('third_level_contribution')->nullable()->comment();
            $table->double('alter_service')->nullable()->comment();
            $table->double('iva')->nullable()->comment();
            $table->double('nequi_commission')->nullable()->comment();
            $table->double('nequi_commission_provider')->nullable()->comment();
            $table->string('for_meta')->nullable()->comment();
            $table->string('time_rut_limit')->nullable()->comment('Tiempo a partir de la fecha de registro para subir el RUT en caso de no haberlo subido');
            $table->string('service_cancel')->nullable()->comment('numero de servicio cancelado alter');
            $table->string('service_off_answer')->nullable()->comment('servicio sin respuesta alter');
            $table->double('transactional_expenses')->nullable()->comment('gastos transacionales');
            $table->double('group_contribution')->nullable()->comment('aporte grupo');
            $table->double('son_contribution')->nullable()->comment('aporte contribución hijo');
            $table->double('grandchildren_contribution')->nullable()->comment('aporte contribución nieto');
            $table->double('great_grandchildren_contribution')->nullable()->comment('aporte contribución bisnietos');
            $table->string('url')->nullable()->comment();
            $table->longText('terms_conditions')->nullable()->comment('termnos y condiciones');
            $table->double('traffic_density')->nullable()->comment('valor de densidad del trafico');
            $table->double('extra_luxury_taxi')->nullable()->comment('extra lujo taxi');
            $table->double('extra_luxury_taxi_bogota')->nullable()->comment();
            $table->double('extra_luxury_taxi_medellin')->nullable()->comment();
            $table->double('extra_luxury_taxi_cali')->nullable()->comment();

            $table->integer('cut_date_periodicity')->nullable()->comment('Fecha corte periodicidad. 0 = Semanal 1 = Quincenal 2 = Mensual');
            $table->integer('cut_date_day_week')->nullable()->comment('Fecha corte dias de la semana, 0 = domingo, 1 = lunes, ...');
            $table->string('cut_date_initial')->nullable()->comment('Fecha corte inicial');
            $table->string('cut_date_end')->nullable()->comment('Fecha corte fin');
            $table->string('cut_date_day_month')->nullable()->comment('Fecha corte del dia de mes');
            $table->integer('value_domiciliary')->nullable()->comment('valor del domicilio');
            $table->double('value_trajectory')->nullable()->comment('valor de trayectoria');
            $table->double('percentage_business')->nullable()->comment('porcentaje por negocio');


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
        Schema::dropIfExists('alter_configurations');
    }
}
