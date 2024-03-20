<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Agendamiento;
use App\Models\Reporte_cumplimiento;
use App\Models\tipomascota;
use App\Models\tipomascota_has_actividad;


class ActividadApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividad = Actividad::all();
        return response()->json($actividad, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actividad = new Actividad();
        $actividad->nombre_actividad = $request->nombre_actividad;
        $actividad->descripcion_actividad = $request->descripcion_actividad;
       
    
        
        $actividad->save();

        return response()->json($actividad, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actividad = Actividad::with('tipomascota')->where('id',$id)->first();
        return response()->json($actividad, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actividad = Actividad::find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }

        $actividad->nombre_actividad = $request->nombre_actividad;
        $actividad->descripcion_actividad = $request->descripcion_actividad;
    
    
        $actividad->save();

        return response()->json($actividad, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad = Actividad::find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }
        Tipomascota_has_actividad::where("actividad_id", $id)->delete();
        $actividad->delete();
        return response()->json(['message' => 'Actividad eliminada correctamente'], 200);
    }

    /**
     * Marca una actividad como cumplida.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

     public function marcarComoCumplida($id)
     {
         $actividad = Actividad::find($id);
     
         if (!$actividad) {
             return response()->json(['message' => 'Actividad no encontrada'], 404);
         }
     
         // Marcar la actividad como cumplida
         $actividad->cumplida = true;
         $actividad->save();
     
          /* Cargar la relación 'agendamiento' para acceder a sus propiedades
         $actividad->load('agendamiento');
     
         // Verificar si la relación agendamiento está cargada correctamente
         if (!$actividad->agendamiento) {
             return response()->json(['message' => 'No se encontró agendamiento para la actividad'], 404);
         }
     
         // Verificar si el logro_id está presente en la relación agendamiento
         if (!$actividad->agendamiento->logro_id) {
             return response()->json(['message' => 'No se encontró logro para el agendamiento'], 404);
         }
     
         // Generar el reporte de cumplimiento
         $reporte_cumplimiento = new Reporte_cumplimiento();
         $reporte_cumplimiento->tiempo_cumplido = $actividad->duracion;
         $reporte_cumplimiento->observaciones = 'Actividad cumplida';
         $reporte_cumplimiento->logro_id = $actividad->agendamiento->logro_id;
         $reporte_cumplimiento->user_id = $actividad->agendamiento->user_id;
     
         // Se debe asignar el logro correspondiente
         $reporte_cumplimiento->save();
     
         return response()->json(['message' => 'Actividad marcada como cumplida y reporte de cumplimiento generado'], 200);
     }*/
     

    
}
 //funcion para mostrar las actividades para cada tipo de mascota
public function obtenerActividadesMascota($id){
    $actividadmascota = tipomascota_has_actividad::where("tipomascota_id", $id)->get();
    
    
    $actividades = array();
    foreach ($actividadmascota as $ac) {
        $actividad = Actividad::where("id", $ac->actividad_id)->first();

        array_push($actividades, $actividad);
    }

    return response()->json($actividades, 200);



}

//funcion para asignar actividades a tipos de mascota especific
public function asignarActividadTipoMascota(Request $request)
{
   
    $request->validate([
        'actividad_id' => 'required|integer',
        'tipo_mascota_id' => 'required|array',
    ]);

    Tipomascota_has_actividad::where('actividad_id', $request->input('actividad_id'))->delete();

    foreach($request->tipo_mascota_id as $tipo) {
        $actividadTipoMascota = new Tipomascota_has_actividad();
        $actividadTipoMascota->actividad_id = $request->input('actividad_id');
        $actividadTipoMascota->tipomascota_id = $tipo;
        $actividadTipoMascota->save();
    }
    

    
    return response()->json(['mensaje' => 'Actividad asignada al tipo de mascota correctamente'], 201);
}




}








