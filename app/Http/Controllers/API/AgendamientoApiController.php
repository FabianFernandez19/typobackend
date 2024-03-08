<?php

namespace App\Http\Controllers\API;


use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Agendamiento;
use App\Models\Informacion;
use App\Models\User;
use App\Models\Reporte_cumplimiento;
use App\Http\Controllers\API\LogrosApiController;


use App\Http\Controllers\Controller;

class AgendamientoApiController extends Controller
{

    protected $logroController;
    public function __construct(LogrosApiController $logroController)
    {
        $this->logroController = $logroController;
    }

    public function index()
    {
        //$agendamiento = Agendamiento::all();
        //return response()->json($agendamiento, 200);
        $consulta = DB::table('agendamiento')->join('informacion AS i','agendamiento.infomascota_id', '=', 'i.id')
            ->join('users AS u','agendamiento.user_id', '=', 'u.id')
            ->join('actividad AS ac','agendamiento.actividades_id', '=', 'ac.id')
            ->select('agendamiento.*', 'i.id', 'i.Nombre_Mascota', 'u.id', 'u.name', 'ac.id', 'ac.nombre_actividad')
            ->get();
        return response()->json($consulta, 200);
    }


    public function store(Request $request)
    {
        $agendamiento = new Agendamiento();
        $agendamiento->tiempo_asignado_actividad = $request->tiempo_asignado_actividad;
        $agendamiento->Fecha_Agendamiento = $request->Fecha_Agendamiento;
        $agendamiento->cumplida = $request->cumplida;
        $agendamiento->infomascota_id = $request->infomascota_id;
        $agendamiento->actividades_id = $request->actividades_id;
        $agendamiento->user_id = $request->user_id;
        $agendamiento->save();
        return response()->json($agendamiento, 200);
    }

    public function show($id)
    {
        $agendamiento = Agendamiento::find($id);
        return response()->json($agendamiento, 200);
    }

    public function update(Request $request, $id)
    {
        $agendamiento = Agendamiento::find($id);
        $agendamiento->tiempo_asignado_actividad = $request->tiempo_asignado_actividad;
        $agendamiento->Fecha_Agendamiento = $request->Fecha_Agendamiento;
        $agendamiento->cumplida = $request->cumplida;
        $agendamiento->infomascota_id = $request->infomascota_id;
        $agendamiento->actividades_id = $request->actividades_id;
        $agendamiento->user_id = $request->user_id;
        $agendamiento->save();
        return response()->json($agendamiento, 200);
    }

    public function destroy($id)
    {
        $agendamiento = Agendamiento::find($id);
        if ($agendamiento) {
            $agendamiento->delete();
            return response()->json(null, 200);
        } else {
            return response()->json(['message' => 'No se pudo encontrar el Agendamiento'], 404);
        }
    }

    public function calcularTiempoAcumuladoUsuario($user_id)
{

    //este sirve bien pero toca cambiarlo, lo dejo para guiarme
    /*$agendamiento = DB::table('agendamiento')
            ->selectRaw('SUM(agendamiento.tiempo_asignado_actividad) as total')
            ->join('actividad', 'agendamiento.id', '=', 'actividad.agendamiento_id')
            ->where('actividad.cumplida','=', 1)
            ->where('agendamiento.user_id','=', $user_id)
            ->get();

       $totalSQL = $agendamiento[0]->total;


    if (strlen($totalSQL)>5) {
        $timeTotal = substr($totalSQL, 0, 2).":".substr($totalSQL, 2, 2).":".substr($totalSQL, 4, 2);
    } else {
        $timeTotal = "0".substr($totalSQL, 0, 1).":".substr($totalSQL, 1, 2).":".substr($totalSQL, 3, 2);
    }
   
    return response()->json(['actividades' => $timeTotal], 200);
    */


    //aca ya no se necesita hacer el join se hace la consulta directamente
    $agendamiento = DB::table('agendamiento')
    ->selectRaw('SUM(agendamiento.tiempo_asignado_actividad) as total')
    ->where('agendamiento.cumplida', '=', 1)
    ->where('agendamiento.user_id', '=', $user_id)
    ->get();


$totalSQL = $agendamiento[0]->total;


if (strlen($totalSQL)>5) {
$timeTotal = substr($totalSQL, 0, 2).":".substr($totalSQL, 2, 2).":".substr($totalSQL, 4, 2);
} else {
$timeTotal = "0".substr($totalSQL, 0, 1).":".substr($totalSQL, 1, 2).":".substr($totalSQL, 3, 2);
}

return response()->json(['actividades' => $timeTotal], 200);

    
    
    
    
    $agendamientos = Agendamiento::where('user_id', $user_id)->get();

    if ($agendamientos->isEmpty()) {
        return response()->json(['message' => 'No se encontraron agendamientos para este usuario'], 404);
    }

    $tiempoAcumuladoTotal = 0;

    foreach ($agendamientos as $agendamiento) {
        
        $actividadesCumplidas = $agendamiento->actividades()->where('cumplida', true)->get();
        

        foreach ($actividadesCumplidas as $actividad) {
            $tiempoAcumuladoTotal += $actividad->tiempo_asignado_actividad;
        }
    }

    return response()->json(['tiempo_acumulado_total' => $tiempoAcumuladoTotal], 200);
}








public function actualizarTiempoTotalPorMascota(Request $request)
{
   
    $agendamiento_id = $request->agendamiento_id;

    $agendamiento = Agendamiento::find($agendamiento_id);

    if (!$agendamiento) {
        return response()->json(['mensaje' => 'Agendamiento no valido'], 401);
    }



    // Verificar si el agendamiento ya está marcado como cumplido
if ($agendamiento->cumplida) {
    return response()->json(['mensaje' => 'El agendamiento ya ha sido marcado como cumplido previamente'], 401);
}






    $date1=date("Y-m-d");
    //return response()->json(['mensaje' => $date1], 200);
    //2024-03-06 13:16:19
    //2024-03-05 12:00:00
    //$days = date_diff($date1,$agendamiento->Fecha_Agendamiento);

    $date1=date("Y-m-d");
    $date1_1=date_create($date1);

    $date2 = substr($agendamiento->Fecha_Agendamiento, 0, stripos($agendamiento->Fecha_Agendamiento, " ")+1);
    $date1_2=date_create($date2);
    $days = date_diff($date1_1,$date1_2);
    $cantidad = $days->format("%R%a");
    //return response()->json(['mensaje' => intval($cantidad)], 200);
    if (intval($cantidad)<0) {
        return response()->json(['mensaje' => 'Agendamiento no valido, no se puede realizar la accion ya que el tiempo caduco'], 401);
    } 

    $tiempo = $agendamiento->tiempo_asignado_actividad;

    $agendamiento->cumplida=1;
    $agendamiento->save();

    $mascota = Informacion::find($agendamiento->infomascota_id);

    if (!$mascota) {
        return response()->json(['mensaje' => 'Mascota no existe'], 401);
    }

    $time1 = $mascota->tiempo_total;
    $time2 = $tiempo;
    $secs = strtotime($time2) - strtotime("00:00:00");
    $result = date("H:i:s", strtotime($time1) + $secs);

    $mascota->tiempo_total=$result;
    $mascota->save();



    $this->logroController->asignarLogrosAMascotas();

    /*
    $user = Auth::user();
    $agendamientos = Agendamiento::where("user_id", $user->id)->get();

   
    $tiempo_acumulado_por_mascota = [];

    
    foreach ($agendamientos as $registro) {
        $mascota_id = $registro->mascota_id;
        $tiempo_actividad = $registro->tiempo_asignado_actividad;

        if (!isset($tiempo_acumulado_por_mascota[$mascota_id])) {
            $tiempo_acumulado_por_mascota[$mascota_id] = 0;
        }

        if ($registro->cumplida == 1) {
            $tiempo_acumulado_por_mascota[$mascota_id] += $tiempo_actividad;
        }
    }

    
    foreach ($tiempo_acumulado_por_mascota as $mascota_id => $tiempo_total) {
        $mascota = Informacion::find($mascota_id);
        if ($mascota) {
            $mascota->tiempo_total = $tiempo_total;
            $mascota->save();
        }
    }
    */

    
    return response()->json(['mensaje' => 'Tiempos totales de mascotas actualizados correctamente'], 200);
}


}














