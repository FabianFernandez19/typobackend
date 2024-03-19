<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Logros;
use App\Models\Informacion;
use App\Models\Mascota_has_logros;
use Illuminate\Support\Facades\DB;


class LogrosApiController extends Controller
{
    public function index()
    {
        $logros = Logros::all();
        return response()->json($logros, 200);
    }
    
   /* public function store(Request $request)
    {
        $request->validate([
            'tipoLogro' => 'required|string',
            'tiempoSemanal' => 'required|time',
            'dias' => 'required|integer'
        ]);
    
        $logro = Logros::create($request->all());
        return response()->json($logro, 201);
    }*/

    public function store(Request $request)
{
    $request->validate([
        'tipoLogro' => 'required|string',
        'tiempoSemanal' => 'required|regex:/([0-9][0-9]:[0-9][0-9]:[0-9][0-9])/u',
        
    ]);
    

    $logro = Logros::create($request->all());
    return response()->json($logro, 201);
}

    public function show($id)
    {
        $logro = Logros::findOrFail($id);
        return response()->json($logro, 200);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipoLogro' => 'required|string',
            //'tiempoSemanal' => 'required|date_format:H:i:s',
            'tiempoSemanal' => 'required|regex:/([0-9][0-9]:[0-9][0-9]:[0-9][0-9])/u'
            
        ]);
    
        $logro = Logros::findOrFail($id);
        $logro->update($request->all());
        return response()->json($logro, 200);
    }
    
    public function destroy($id)
    {
        $logro = Logros::findOrFail($id);
        $logro->delete();
        return response()->json(null, 204);
    }

   public function asignarLogrosAMascotas()
{
   
    $mascotas = Informacion::all();

    $tiempos = array();
    $logros = array();

    foreach ($mascotas as $mascota) {
        $tiempoTotal = $mascota->tiempo_total;
        $tiempos[] = $tiempoTotal;

        //return response()->json($tiempoTotal);
        
        $logrosDisponibles = Logros::where('tiempoSemanal', '<=', $tiempoTotal)->get();
        

        foreach ($logrosDisponibles as $logro) {
            $logro_User = Mascota_Has_Logros::where('mascota_id', $mascota->id)->where('logros_id', $logro->id)->first();

            if (count((array)$logro_User)==0) {
                Mascota_Has_Logros::create([
                 'mascota_id' => $mascota->id,
                    'logros_id' => $logro->id
                ]);
                $logros[] = $logro;
            }
            
           // return response()->json(['logro' => $logro, 'message' => 'Logro asignado correctamente'], 200);
        }
        
    }
    //return response()->json(['logros' => $logros, 'message' => 'Logro asignado correctamente'], 200);


}  







}





   /* public function asignarLogros()
    {
        
        $usuarios = User::all();
    
        foreach ($usuarios as $usuario) {
            
            $tiempoAcumulado = obtenerTiempoAcumulado($usuario->id);
    
            
            $logros = Logro::orderBy('tiempoSemanal', 'desc')->get();
    
            
            foreach ($logros as $logro) {
                if (strtotime($tiempoAcumulado) >= strtotime($logro->tiempoSemanal)) {
                    
                    $usuario->logros()->attach($logro->id);
                    
                }
            }
        }
    
        return response()->json(['message' => 'Logros asignados correctamente a los usuarios'], 200);
    }*/
    
    
    
   /* function obtenerTiempoAcumulado($usuario_id)
    {
        $agendamientos = DB::table('agendamiento')
                            ->where('user_id', $usuario_id)
                            ->where('cumplida', true)
                            ->sum('tiempo_asignado_actividad');
    
        
        $horas = floor($agendamientos / 3600);
        $minutos = floor(($agendamientos - ($horas * 3600)) / 60);
        $segundos = $agendamientos - ($horas * 3600) - ($minutos * 60);
    
        return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
    }
    */




    

   /* public function asignarLogro(Request $request)
    {
        $request->validate([
            'tiempoSemanal' => 'required|date_format:H:i:s',
            'dias' => 'required|integer',
            'usuario_id' => 'required|integer'
        ]);
        
        $tiempoSemanal = $request->tiempoSemanal;
        $diasInteraccion = $request->dias;
        // Corregir el nombre del campo dias_interaccion a dias
    
        $logro = Logros::where('tiempoSemanal', $tiempoSemanal)
            ->where('dias', $diasInteraccion)
            ->first();
    
        if ($logro) {
            $new_logro = new User_has_logros();
            $new_logro->user_id = $request->usuario_id;
            $new_logro->logros_id = $logro->id; 
            $new_logro->save();
    
            return response()->json(['logro' => $logro, 'message' => 'Logro asignado correctamente'], 200);
        } else {
            return response()->json(['message' => 'No se encontró ningún logro correspondiente'], 404);
        }
    }
    
    





    public function logrosAsignadosAUsuario($usuario_id)
    {
        $logrosAsignados = User_has_logros::where('user_id', $usuario_id)
                                           ->with('logros') // Cambio aquí
                                           ->get();
    
        return response()->json($logrosAsignados, 200);
    }*/
   






