<?php

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
            $table->id();
            $table->unsignedBigInteger('id_entity')->nullable();
            $table->foreign('id_entity')->references('id')->on('entities');
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('password');
            $table->enum('role',['Vendedor','Administrador','Gestor'])->default('Vendedor');
            $table->enum('status',['Disponible','No disponible'])->default('Disponible');
            $table->rememberToken();
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
