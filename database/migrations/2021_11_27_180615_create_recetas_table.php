<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        //Tabla Categorias
        Schema::create('categorias', function (Blueprint $table){
            $table->id();
            $table->string('nombre');
            //auditoria
            $table->timestamps();
            
        });
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('ingredientes');
            $table->text('preparacion');
            $table->string('imagen');
            $table->foreignId('user_id')->references('id')->on('users')->comment('El usuario crea la receta');
            //categorias
            $table->foreignId('categoria_id')->references('id')->on('categorias')->comment('Categoria de la receta');
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
        Schema::dropIfExists('recetas');
        Schema::dropIfExists('categorias');
    }
}
