<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Actividad;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
   
   protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        /*$schedule->call(function () {
            
        })->monthlyOn(1, '00:01');*/
        /*$schedule->call(function () {
            $actividad = new Actividad();
            $actividad->nombre_actividad="Actividad#";
            $actividad->descripcion_actividad="Actividad#";
            $actividad->save();
        })->everyMinute();
        */
        $schedule->call('App\Http\Controllers\API\reporte_cumplimientoApiController@generarReporteCumplimientoMensual')->everyMinute();
    }


 
   /*  protected function schedule(Schedule $schedule)
{
    $schedule->call('App\Http\Controllers\API\reporte_cumplimientoApiController@generarReporteCumplimientoMensual')
             ->monthlyOn(1, '00:01');
}*/


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
