<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->string('value');
            $table->enum('extras', [0, 1]);
            $table->enum('approved', [0, 1]);
            $table->enum('customizable', [0, 1])->comment('personalizable');
            $table->enum('status', [0, 1])->default(1);

            $table->unsignedInteger('id_place');
            $table->foreign('id_place')->references('id')->on('places');

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedInteger('id_category_service');
            $table->foreign('id_category_service')->references('id')->on('category_services');

            $table->timestamps();
        });

        Schema::create('place_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type_schedule', [1,2,3])->comment('1 = Lun a Vier, 2 = Sabado, 3 = Domingo');
            $table->string('since')->comment('desde');
            $table->string('since_type')->comment('AM, PM');
            $table->string('until')->comment('hasta');
            $table->string('until_type')->comment('AM, PM');

            $table->unsignedInteger('id_place');
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
        Schema::dropIfExists('place_items');
        Schema::dropIfExists('place_schedule');
    }
}
