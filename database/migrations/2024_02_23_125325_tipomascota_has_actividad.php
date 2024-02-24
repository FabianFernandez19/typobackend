<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TipomascotaHasActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
            Schema::create('tipomascota_has_actividad', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tipomascota_id');
                $table->foreign('tipomascota_id')->references('id')->on('tipomascota');
                $table->unsignedBigInteger('actividad_id'); 
                $table->foreign('actividad_id')->references('id')->on('actividad');
                $table->timestamps();
            });
        
    
  
    }
    public function down(): void
    {
        Schema::dropIfExists('tipomascota_has_actividad');
    }




    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */

