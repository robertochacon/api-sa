<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_entity')->nullable();
            $table->foreign('id_entity')->references('id')->on('entities');
            $table->json('products')->nullable();
            $table->integer('table')->nullable();
            $table->integer('total')->nullable();
            $table->string('note')->nullable();
            $table->boolean('in_restaurant')->default('1');
            $table->enum('status',['Recibida','Preparando','Completada','Facturada','Cancelada'])->default('Recibida');
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
        Schema::dropIfExists('orders');
    }
}
