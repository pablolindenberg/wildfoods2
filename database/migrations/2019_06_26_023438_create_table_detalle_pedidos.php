<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetallePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {   
            $table->increments('id');
            $table->integer('idpedido')->unsigned(); 
            $table->integer('idproducto')->unsigned(); 
            $table->integer('cantidad');
            $table->integer('total');   
            $table->foreign('idpedido')->references('id')->on('pedidos');
            $table->foreign('idproducto')->references('id')->on('productos');
            $table->timestamps(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
