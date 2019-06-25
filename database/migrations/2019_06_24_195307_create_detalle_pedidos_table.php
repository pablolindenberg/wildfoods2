<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {   
            
            $table->integer('idpedido')->unsigned(); 
            $table->integer('idproducto')->unsigned(); 
            $table->integer('cantidad');
            $table->integer('total');   
            $table->foreign('idpedido')->references('id')->on('pedidos');
            $table->foreign('idproducto')->references('id')->on('productos');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_pedidos');
    }
}
