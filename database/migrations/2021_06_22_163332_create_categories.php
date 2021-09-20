<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('status')->default('1');
            $table->timestamps();
        });


        Schema::create('category_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->unsignedInteger('id_category');
            $table->foreign('id_category')->references('id')->on('categories');

            $table->unsignedInteger('id_place');
            $table->foreign('id_place')->references('id')->on('places');

            $table->unsignedInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');

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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_service');
    }
}
