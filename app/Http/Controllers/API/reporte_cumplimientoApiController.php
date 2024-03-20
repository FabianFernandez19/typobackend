<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reporte_cumplimiento; 
use App\Models\user;
use App\Models\logros;
use App\Models\UserHasLogro;
use App\Models\Agendamiento;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class reporte_cumplimientoApiController extends Controller

{

    
    public function index()
    {
        $user = Auth::user();
        $reporte_cumplimiento = Reporte_cumplimiento::where('user_id', $user->id)->get();
        return response()->json($reporte_cumplimiento, 200);


        /*$reporte_cumplimiento = Reporte_cumplimiento::all(); // Obtener todos los registros de la tabla de logros
        return response()->json($reporte_cumplimiento, 200);*/

    }

    public function store(Request $request)
    {
        
        $reporte_cumplimiento = new Reporte_cumplimiento();
        $reporte_cumplimiento-> mes = $request->mes;
        $reporte_cumplimiento-> porcentaje_cumplimiento = $request->porcentaje_cumplimiento;
        $reporte_cumplimiento-> total_agendamientos_cumplidos = $request->total_agendamientos_cumplidos;
        $reporte_cumplimiento-> agendamientos_no_cumplidos = $request->agendamientos_no_cumplidos;
        $reporte_cumplimiento-> user_id = $request->user_id;
        $reporte_cumplimiento->save();
        return response()->json($reporte_cumplimiento, 201);

    }

    public function show($id)
    {
        $reporte_cumplimiento = Reporte_cumplimiento::find($id);
        return response()->json($reporte_cumplimiento,200); 
    }

    public function update(Request $request, $id)
    {
            $reporte_cumplimiento = Reporte_cumplimiento::find($id);
            $reporte_cumplimiento-> mes = $request->mes;
            $reporte_cumplimiento-> porcentaje_cumplimiento = $request->porcentaje_cumplimiento;
            $reporte_cumplimiento-> total_agendamientos_cumplidos = $request->total_agendamientos_cumplidos;
            $reporte_cumplimiento-> agendamientos_no_cumplidos = $request->agendamientos_no_cumplidos;
            $reporte_cumplimiento-> user_id = $request->user_id;
            $reporte_cumplimiento->update();
            return response()->json($reporte_cumplimiento, 201);
    }


    public function destroy($id)
    {
        $reporte_cumplimiento = Reporte_cumplimiento::find($id);
        if($reporte_cumplimiento){
        $reporte_cumplimiento->delete();
        return response()->json($reporte_cumplimiento, 200);
    }else{
        return response()->json(['message' => 'Informacion de reporte de cumplimiento no encontrada'], 404);
    }
    }

    public function generarReporteCumplimientoMensual()
    {
        $clientes = User::all();
        foreach ($clientes as $cliente) {
            $this->generarReporteCumplimientoMensualPorUsuario($cliente->id);
        }
    }

    public function generarReporteCumplimientoMensualPorUsuario($usuarioId)
{  
    $user = Auth::user();
    // Obtener el primer y último día del mes actual
    $primerDiaMes = Carbon::now()->startOfMonth();
    $ultimoDiaMes = Carbon::now()->endOfMonth();

    $reporte = Reporte_Cumplimiento::where('mes', $primerDiaMes->format('m/Y'))
                                    ->where('user_id', $usuarioId)
                                    ->first();

    if (!$reporte) {
        $reporte = new Reporte_Cumplimiento();
    }

    // Obtener los agendamientos cumplidos por el usuario dentro del mes actual
    $agendamientosCumplidos = Agendamiento::where('user_id', $usuarioId)
                                           ->whereBetween('Fecha_Agendamiento', [$primerDiaMes, $ultimoDiaMes])
                                           ->where('cumplida', 1)
                                           ->get();

    // Obtener los agendamientos NO cumplidos por el usuario dentro del mes actual
    $agendamientosNoCumplidos = Agendamiento::where('user_id', $usuarioId)
                                             ->whereBetween('Fecha_Agendamiento', [$primerDiaMes, $ultimoDiaMes])
                                             ->where('cumplida', 0)
                                             ->get();

    // Contar el número total de agendamientos realizados por el usuario
    $totalAgendamientos = Agendamiento::where('user_id', $usuarioId)
                                      ->whereBetween('Fecha_Agendamiento', [$primerDiaMes, $ultimoDiaMes])
                                      ->count();

    // Calcular el porcentaje de cumplimiento por el usuario
    $porcentajeCumplimiento = $totalAgendamientos > 0 ? ($agendamientosCumplidos->count() / $totalAgendamientos) * 100 : 0;

    // Guardar el reporte en la base de datos
    $reporte->mes = $primerDiaMes->format('m/Y');
    $reporte->porcentaje_cumplimiento = $porcentajeCumplimiento;
    $reporte->total_agendamientos_cumplidos = $agendamientosCumplidos->count();
    $reporte->agendamientos_no_cumplidos = $agendamientosNoCumplidos->count(); // Nuevo campo agregado
    $reporte->user_id = $usuarioId; // Asignar el ID del usuario al reporte
    $reporte->save();

    // Devolver los agendamientos cumplidos y otra información relevante
    return [
        'agendamientos_cumplidos' => $agendamientosCumplidos,
        'agendamientos_no_cumplidos' => $agendamientosNoCumplidos, // Nuevo campo agregado
        'total_agendamientos' => $totalAgendamientos,
        'porcentaje_cumplimiento' => $porcentajeCumplimiento,
        'mes_reporte' => $primerDiaMes->format('m/Y')
    ];
}






    public function obtenerTodosAgendamientosConPorcentajeCumplimiento()
    {
     
    /*
    $agendamientos = Agendamiento::all();
    
    
    $totalAgendamientos = $agendamientos->count();
    
   
    $totalAgendamientosCumplidos = $agendamientos->where('cumplida', 1)->count();
    
   
    $porcentajeCumplimiento = $totalAgendamientos > 0 ? ($totalAgendamientosCumplidos / $totalAgendamientos) * 100 : 0;
    
    
    return $agendamientos->map(function ($agendamiento) use ($totalAgendamientosCumplidos, $totalAgendamientos, $porcentajeCumplimiento) {
      
        $fechaAgendamiento = Carbon::parse($agendamiento->Fecha_Agendamiento);
        
        return [
            'id' => $agendamiento->id,
            'mes' => $fechaAgendamiento->format('m/Y'),
            'porcentaje_cumplimiento' => $porcentajeCumplimiento,
            'total_agendamientos_cumplidos' => $totalAgendamientosCumplidos,
            'user_id' => $agendamiento->user_id
        ];

    });
    */
    $reporte_cumplimiento = Reporte_Cumplimiento::all();
    return response()->json($reporte_cumplimiento);


        
    }
        
    }
    








    


   /* public function asignarLogros($id)
    {
        $reporte_cumplimiento = Reporte_cumplimiento::find($id);

        if (!$reporte_cumplimiento) {
            return response()->json(['message' => 'Reporte de cumplimiento no encontrado'], 404);
        }

        $user_id = $reporte_cumplimiento->user_id;
        $tiempo_cumplido = $reporte_cumplimiento->tiempo_cumplido;

        // Buscar logros que coincidan con el tiempo cumplido
        $logros = Logro::where('tiempoSemanal', '<=', $tiempo_cumplido)->get();

        // Asignar logros al usuario
        foreach ($logros as $logro) {
            $userHasLogro = new UserHasLogro();
            $userHasLogro->user_id = $user_id;
            $userHasLogro->logro_id = $logro->id;
            $userHasLogro->save();
        }

        return response()->json(['message' => 'Logros asignados correctamente'], 200);
    }*/










 
