<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcategoria')->unsigned();
            $table->string('SKU',50)->nullable(false);
            $table->string('nombre',100)->unique()->nullable(false);
            $table->string('marca',100);
            $table->string('descripcion',200);
            $table->integer('contenido_display');
            $table->integer('valor_neto')->nullable(false);
            $table->integer('valor_bruto')->nullable(false);
            $table->integer('pvp_unitario');    
            $table->integer('total_neto')->nullable(false);
            $table->integer('total')->nullable(false);
            $table->decimal('descuento',3,2)->default(0);
            $table->binary('imagen');
            $table->integer('stock');
            $table->boolean('estado')->default(1);       
            $table->timestamps();
            $table->foreign('idcategoria')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
