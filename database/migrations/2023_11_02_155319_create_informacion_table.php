<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('informacion', function (Blueprint $table) {
        $table->id();
        $table->string('Nombre_Mascota');
        $table->tinyinteger('Edad');
        $table->string('Raza');
        $table->tinyinteger('Peso');
        $table->float('Tamaño');
        $table->string('Sexo');
        $table->time('tiempo_total')->default('00:00:00');
        $table->foreignId('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreignId('id_tipomascota');
        $table->foreign('id_tipomascota')->references('id')->on('tipomascota');
        $table->timestamps(); 

        
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion');
    }
};