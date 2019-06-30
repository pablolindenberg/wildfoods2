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
            $table->string('SKU',50)->nullable();
            $table->string('nombre',100)->unique()->nullable();
            $table->string('marca',100)->nullable();
            $table->string('descripcion',200)->nullable();
            $table->integer('contenido_display')->nullable();;
            $table->integer('valor_neto')->nullable();
            $table->integer('valor_bruto')->nullable();
            $table->integer('pvp_unitario')->nullable();    
            $table->integer('total_neto')->nullable();
            $table->integer('total')->nullable();
            $table->decimal('descuento',3,2)->default(0)->nullable();
            $table->binary('imagen')->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('estado')->default(1)->nullable();       
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
