<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_service')->nullable();
            $table->foreign('id_service')->references('id')->on('services');

            $table->float('commission_alter')->nullable()->comment('comision alter');
            $table->float('iva_commission_alter')->comment('iva comision alter');

            //cliente
            $table->float('commission_first_level_client')->nullable()->comment('comision cliente con primer nivel');

            $table->unsignedInteger('id_first_level_client')->nullable()->comment('id cliente con primer nivel');
            $table->foreign('id_first_level_client')->references('id')->on('users');

            $table->float('commission_second_level_client')->nullable()->comment('comision cliente con segundo nivel');

            $table->unsignedInteger('id_second_level_client')->nullable()->comment('id cliente con segundo nivel');
            $table->foreign('id_second_level_client')->references('id')->on('users');

            $table->float('commission_third_level_client')->nullable()->comment('comision cliente con tercer nivel');

            $table->unsignedInteger('id_third_level_client')->nullable()->comment('id cliente con tercer nivel');
            $table->foreign('id_third_level_client')->references('id')->on('users');

            $table->float('total_client')->nullable()->comment('total del cliente');

            // proveedor
            $table->float('commission_alter_provider')->nullable()->comment('comision alter proveedor');
            $table->float('iva_commission_alter_provider')->nullable()->comment('comision alter');
            $table->float('commission_first_level_provider')->comment('comision provvedor primero nivel');

            $table->unsignedInteger('id_first_level_provider')->nullable()->comment('id proveedor con primer nivel');
            $table->foreign('id_first_level_provider')->references('id')->on('users');

            $table->float('commission_second_level_provider')->nullable()->comment('comision provvedor segundo nivel');

            $table->unsignedInteger('id_second_level_provider')->nullable()->comment('id proveedor con segundo nivel');
            $table->foreign('id_second_level_provider')->references('id')->on('users');

            $table->float('commission_third_level_provider')->nullable()->comment('comision provvedor tercer nivel');

            $table->unsignedInteger('id_third_level_provider')->nullable()->comment('id proveedor con tercer nivel');
            $table->foreign('id_third_level_provider')->references('id')->on('users');

            $table->float('total_provider')->nullable()->comment('total del proveedor');

            $table->float('value_nequi')->nullable()->comment('valor nequi');
            $table->float('commission_nequi')->nullable()->comment('Comision que le cobra al cliente');

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
        Schema::dropIfExists('transactions');
    }
}
