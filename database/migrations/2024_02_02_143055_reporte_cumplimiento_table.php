<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReporteCumplimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_cumplimiento', function (Blueprint $table) {
            $table->id();
            $table->string('mes');
            $table->decimal('porcentaje_cumplimiento', 5, 2);
            $table->unsignedInteger('total_agendamientos_cumplidos')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporte_cumplimiento');
    }
}
