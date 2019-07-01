<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_productos', function (Blueprint $table) {   
            $table->increments('id');
            $table->string('accion'); 
            $table->string('sku');   
            $table->string('nombreProducto');
            $table->integer('precioAnterior');  
            $table->integer('precioNuevo');
            $table->integer('idUsuario');  
            $table->string('nombreUsuario');          
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
        //
    }
}
