<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('usuario')->unique;
            $table->string('password');
            $table->string('email')->unique();
            $table->boolean('estado')->default(1);

            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');


            $table->rememberToken();
            $table->timestamps(false);
        });
        DB::table('users')->insert(array('usuario'=>'admin','password'=>bcrypt('admin'),'email'=>'admin@admin.cl','estado'=>'1','idrol'=>'1'));
    }

    /**   * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
