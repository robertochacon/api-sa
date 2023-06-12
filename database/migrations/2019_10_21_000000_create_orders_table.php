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
            $table->json('products')->nullable();
            $table->integer('table')->nullable();
            $table->integer('total')->nullable();
            $table->string('note')->nullable();
            $table->boolean('in_restaurant')->default('1');
            $table->enum('status',['En proceso','Completada','Cancelada'])->default('En proceso');
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
