<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\TipomascotaApiController;
use App\Http\Controllers\API\InformacionApiController;
use App\Http\Controllers\API\AgendamientoApiController;
use App\Http\Controllers\API\ActividadApiController;
use App\Http\Controllers\API\Informacion_ActividadController;
//use App\Http\Controllers\API\HomeApiController;
use App\Http\Controllers\API\RolApiController;
use App\Http\Controllers\API\UsuarioApiController;
use App\Http\Controllers\API\reporte_cumplimientoApiController;
use App\Http\Controllers\API\LogrosApiController;
use App\Http\Controllers\API\UserhaslogrosApiController; 
use App\Http\Controllers\API\mascota_has_logrosApiController; 


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::apiResource('Agendamiento',AgendamientoApiController::class );

//Route::apiResource('Tipomascota', TipomascotaApiController::class);
//Route::post('reporte_cumplimiento', [reporte_cumplimientoApiController::class, 'guardar']);

Route::post('/logros/asignar', [LogrosApiController::class, 'asignarLogro']);
//Route::get('usuarios/{usuario_id}/logros', [LogrosApiController::class, 'logrosAsignadosAUsuario']);
//Route::apiResource('reporte_cumplimiento', reporte_cumplimientoApiController ::class);
Route::put('/actividades/{id}/marcarcomocumplida', [ActividadApiController::class, 'marcarComoCumplida']);
//Route::get('/agendamiento/{id}/calcular-tiempo-acumulado', 'App\Http\Controllers\API\AgendamientoApiController@calcularTiempoAcumulado');

//Route::get('/agendamientos/{user_id}/calcular-tiempo-acumulado', [AgendamientoApiController::class, 'calcularTiempoAcumuladoUsuario']);
//Route::get('/usuarios/{userId}/tiempo-total', [UsuarioApiController::class, 'obtenerTiempoTotal']);

//Route::post('/actualizar-tiempo-mascotas', [AgendamientoApiController::class, 'actualizarTiempoTotalPorMascota']);
Route::post('/asignar-logros', [LogrosApiController::class, 'asignarLogrosAMascotas'])->name('logros.asignar_logros');
Route::get('/generar-reporte-cumplimiento-mensual', [reporte_cumplimientoApiController::class, 'generarReporteCumplimientoMensual']);







Route::post('/asignar-actividad-tipo-mascota', [ActividadApiController::class, 'asignarActividadTipoMascota']);






//Route::post('Agendamiento',[AgendamientoApiController::class,"store"] );
//Route::get('Agendamiento',[AgendamientoApiController::class,"index"] );
//Route::apiResource('Actividad', ActividadApiController ::class);
//Route::apiResource('Agendamiento',AgendamientoApiController::class );
Route::apiResource('User_has_logros',UserhaslogrosApiController::class );

//Route::post('Agendamiento',[AgendamientoApiController::class,"store"] );













Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class,"login"]);
    Route::post('signup', [AuthController::class,"signup"]);
    Route::post('signupadmin', [AuthController::class,"signupadmin"]);
    

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class,"logout"]);
        Route::get('user', [AuthController::class, 'user']);

          Route::apiResource('Informacion', InformacionApiController::class);
          //Route::apiResource('Agendamiento',AgendamientoApiController::class );
          Route::apiResource('Tipomascota', TipomascotaApiController::class);
          //Route::apiResource('Actividad', ActividadApiController ::class);
          //Route::apiResource('Informacion_Actividad', Informacion_ActividadController::class);
          //Route::apiResource('Home', HomeApiController::class);
          Route::apiResource('reporte_cumplimiento', reporte_cumplimientoApiController::class);
         
          //ruta para mostrar todas las peticiones de los logros asignados a la mascota
          Route::apiResource('mascota_has_logros', mascota_has_logrosApiController::class);

          //ruta para mostrar las actividades para cada tipo de mascota
          Route::get('/obtenerActividadesMascota/{id}', [ActividadApiController::class, 'obtenerActividadesMascota']);
          
          //ruta para mostrar los logros que tiene cada mascota
          Route::get('/mascotas/{mascotaId}/logros', [mascota_has_logrosApiController::class, 'obtenerLogrosDeMascota']);
          
          //ruta para mostrar las mascotas de cada usuario
          Route::get('/getMascotasByUserId/{id}', [InformacionApiController::class, 'getMascotasByUserId']);

         //ruta para mostrar el reporte de cumplimiento por usuario
          Route::get('/reportes/{usuarioId}/cumplimiento-mensual', [reporte_cumplimientoApiController::class, 'generarReporteCumplimientoMensualPorUsuario'])->name('reporte.cumplimiento.mensual');

         
         //ruta para mostrar la informacion del usuario y todas las relaciones uncluyendo mascotas etc
          Route::get('usuarios/{idUsuario}', [UsuarioApiController::class, 'obtenerInformacionUsuario']);

         //Route::post('reporte_cumplimiento', [reporte_cumplimientoApiController::class, 'guardar']);
         
         //ruta para mostrar los agendamientos individuales porm mascota
         Route::get('/agendamientos/{idMascota}', [AgendamientoApiController::class, 'agendamientosPorMascota']);
        
         Route::get('Cantidadmascota', [TipomascotaApiController::class, 'getCantidadmascota']);
         

        //ruta principal para cuando se marque el agendamiento como cumplido y proceda a asignar logros
         Route::post('/actualizar-tiempo-mascotas', [AgendamientoApiController::class, 'actualizarTiempoTotalPorMascota']);

          
          //Route::get('Agendamiento',[AgendamientoApiController::class,"index"] );
          Route::apiResource('Agendamiento',AgendamientoApiController::class );
          Route::apiResource('Actividad', ActividadApiController ::class);

          Route::apiResource('logros', logrosApiController ::class);

          
         

          Route::get('/agendamientos', [reporte_cumplimientoApiController::class,  'obtenerTodosAgendamientosConPorcentajeCumplimiento']);

          



          Route::apiResource('Rol',RolApiController::class);
          Route::apiResource('Usuario',UsuarioApiController::class);
          //Route::post('Tipomascota', [TipomascotaApiController::class,"store"]);

          Route::group(['middleware' => ['role:Administrator']], function () {
          Route::apiResource('Tipomascota', TipomascotaApiController::class)->names([
          'index' => 'tipomascota.index']);
          //Route::apiResource('Agendamiento',AgendamientoApiController::class );
          Route::apiResource('Actividad', ActividadApiController ::class);
          Route::apiResource('Informacion', InformacionApiController::class);
          Route::apiResource('logros', logrosApiController::class);

          Route::get("/Informacion/user/{id}", [InformacionApiController::class,"getMascotasByUserId"]);
          });

          Route::group(['middleware' => ['role:User']], function () {
          Route::get('Tipomascota-user', [TipomascotaApiController::class,"indexUser"]);
          //Route::get('Agendamiento-user',[AgendamientoApiController::class,"index"] );
          Route::get('Actividad-user', [ActividadApiController ::class,"index"]);
          Route::get('Informacion-user', [InformacionApiController::class,"index"]);
        });
      });
});
