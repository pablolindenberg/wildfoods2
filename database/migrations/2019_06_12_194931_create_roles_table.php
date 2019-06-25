<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(1);
            
        });
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador','descripcion'=>'Administradores'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Bodeguero','descripcion'=>'Bodegueros'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Cliente','descripcion'=>'Clientes'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
