<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idusuario')->unsigned(); 
            $table->integer('total');
            $table->string('tracking')->nullable();
            $table->boolean('bodega')->default(0);
            
            //nuevo campo factura
            //$table->binary('factura')->nullable();

            //campo factura booleano para prueba
            $table->boolean('factura')->default(0);
            
            //'estado' ahora es integer en vez de boolean para poder tener mas opciones; 0=Descartado 1=Pendiente 2=Despachado
            $table->integer('estado')->default(1);
            $table->foreign('idusuario')->references('id')->on('users');
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
        Schema::dropIfExists('pedidos');
    }
}
