<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('document_number')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('last_name');
            $table->string('sex')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('cell_fixed')->nullable();
            $table->string('address')->nullable();

            $table->unsignedInteger('id_city')->nullable();
            $table->foreign('id_city')->references('id')->on('cities');

            $table->string('image_user')->nullable();
            $table->string('document_image_front')->nullable();
            $table->string('document_image_back')->nullable();
            $table->string('image_rut')->nullable();
            $table->string('date_limit_rut')->nullable()->comment('limite de fecha de rut');
            $table->string('id_cuenta_bancaria')->nullable();
            $table->string('id_sede')->nullable();
            $table->string('status')->default('1')->nullable()->comment('0=Retiro definitivo, 1=activo, 2=bloqueado tempopral');
            $table->string('availability')->default('0')->nullable()->comment('DISPONIBILIDAD. 0=fuera de servicio, 1=activo (Flag para poner activo a los proveedores)');
            $table->float('alter_cash')->default(0)->comment('saldo disponible de alter');
            $table->string('version_app')->nullable()->comment('version instalada en la app');
            $table->string('id_servicio_activo')->nullable();
            $table->string('id_sub_servicio')->nullable();
            $table->string('cumplemeta')->nullable()->comment('	0 = No Cumplio 1 = Si cumplio la meta 2 = No definido');
            $table->string('tokenpassword')->nullable();
            $table->string('id_chat')->nullable();
            $table->integer('metaquincenal')->default(0);
            $table->string('role')->default(User::USER);
            $table->string('googleauth')->nullable();
            $table->string('pin')->nullable()->comment('pin envio dinero');
            $table->string('promo')->nullable()->comment('0 = Promo Activa 1 = Promo Consumida 2 = No aplica');
            $table->string('tokenfcm')->nullable()->comment('Token para enviar mensajes Firebase Cloud Messaging');

            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
