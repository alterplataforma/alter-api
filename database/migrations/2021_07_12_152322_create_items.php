<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('item_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('aproved', [0, 1]);

            $table->unsignedInteger('id_place_item');
            $table->foreign('id_place_item')->references('id')->on('place_items');

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        Schema::create('item_addictions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',[0, 1])->comment(' 0 = Checkbox, 1 =  Radio');
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->enum('aproved', [0, 1]);

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedInteger('id_item_extra');
            $table->foreign('id_item_extra')->references('id')->on('item_extras');

            $table->enum('status', [0, 1])->default(1);
            $table->timestamps();
        });

        Schema::create('item_domicile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount')->default(1);
            $table->enum('extra',[0, 1])->comment(' 0 = No, 1 =  Sí');
            $table->string('instructions', 255)->nullable();

            $table->unsignedInteger('id_place_item');
            $table->foreign('id_place_item')->references('id')->on('place_items');

            $table->unsignedInteger('id_service');
            $table->foreign('id_service')->references('id')->on('services');

            $table->unsignedInteger('id_item_addiction')->nullable();
            $table->foreign('id_item_addiction')->references('id')->on('item_addictions');

            $table->enum('status', [0, 1])->default(1);
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
        Schema::dropIfExists('item_extras');
        Schema::dropIfExists('item_addictions');
        Schema::dropIfExists('item_domicile');
    }
}
