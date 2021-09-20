<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rate');
            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_city');
            $table->string('type_city')->comment('principal, aledaña (mismo precio)');
            $table->enum('type_calculation',[1, 2])->default(1)->comment('1 = Kilometros, 2 = minutos');
            $table->string('value')->nullable();
            $table->longText('comments');
            $table->string('title');
            $table->enum('status', [0, 1])->default(1);

            $table->unsignedInteger('id_city');
            $table->foreign('id_city')->references('id')->on('cities');

            $table->unsignedInteger('id_service_type');
            $table->foreign('id_service_type')->references('id')->on('service_types');

            $table->unsignedInteger('id_vehicle_type');
            $table->foreign('id_vehicle_type')->references('id')->on('vehicle_types');

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedInteger('id_rate_type');
            $table->foreign('id_rate_type')->references('id')->on('rate_types');

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
        Schema::dropIfExists('rate_type');
        Schema::dropIfExists('rates');
    }
}
