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
        Schema::create('agendamiento', function (Blueprint $table) {
            $table->id();
            $table->time('tiempo_asignado_actividad');
            $table->datetime('Fecha_Agendamiento');
            $table->boolean('cumplida')->default(false);
            $table->unsignedBigInteger('infomascota_id');
            $table->foreign('infomascota_id')->references('id')->on('informacion');
            $table->unsignedBigInteger('actividades_id'); // Cambié el nombre de la columna a 'actividades_id'
            $table->foreign('actividades_id')->references('id')->on('actividad');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamiento');
    }
};
