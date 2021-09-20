<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('theme');

            $table->unsignedInteger('id_user_register');
            $table->foreign('id_user_register')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('frequent_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('question');
            $table->longText('answer');
            $table->longText('keywords')->comment('palabras claves');
            $table->string('status')->default('1');

            $table->unsignedInteger('id_user_register')->comment('usuario que guardo la pregunta');
            $table->foreign('id_user_register')->references('id')->on('users');

            $table->unsignedInteger('id_support_theme');
            $table->foreign('id_support_theme')->references('id')->on('support_themes');

            $table->timestamps();
        });

        Schema::create('support_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket')->comment('numero de ticket');
            $table->longText('description');
            $table->string('status')->default('1');

            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedInteger('id_support_theme');
            $table->foreign('id_support_theme')->references('id')->on('support_themes');

            $table->timestamps();
        });

        Schema::create('support_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('answer');
            $table->string('status')->default('1');

            $table->unsignedInteger('id_operator')->nullable()->comment('tecnico que responde');
            $table->foreign('id_operator')->references('id')->on('users');

            $table->unsignedInteger('id_support_ticket');
            $table->foreign('id_support_ticket')->references('id')->on('support_tickets');

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
        Schema::dropIfExists('support_themes');
        Schema::dropIfExists('frequent_questions');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('support_answers');
    }
}
