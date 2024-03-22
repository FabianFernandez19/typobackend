<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota_has_logros;
use App\Models\Informacion;
use App\Models\logros;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class mascota_has_logrosApiController extends Controller
{


    public function index()
    {
        $user = Auth::user();
    //$mascotaHasLogros = Mascota_has_logros::with('mascota:id,Nombre_Mascota,user_id', 'logros:id,tipoLogro')->get();
    /*$mascotaHasLogros = Mascota_has_logros::with(["mascota" => function($q) use ($user) {
        $q->where('informacion.user_id', '=', $user->id);
    }, 'logros'])->get();*/

    /*select logros.*, i.id, i.Nombre_Mascota FROM logros 
inner join mascota_has_logros AS ml on ml.logros_id = logros.id 
inner join informacion AS i ON ml.mascota_id =  i.id
where i.user_id = 7; */
    $consulta = DB::table('logros')
            ->join('mascota_has_logros AS ml','ml.logros_id', '=', 'logros.id')
            ->join('informacion AS i','ml.mascota_id', '=', 'i.id')
            ->where('i.user_id', '=',$user->id)
            ->select('logros.*', 'i.id', 'i.Nombre_Mascota')
            ->get();






    return response()->json($consulta);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mascota_id' => 'required|exists:informacion,id',
            'logros_id' => 'required|exists:logros,id',
        ]);
    
        $mascotaHasLogro = Mascota_has_logros::create($request->all());
    
        return response()->json($mascotaHasLogro, 201);
    }
    

    public function destroy($id)
    {
        $mascotaHasLogro = Mascota_has_logros::findOrFail($id);
   
        $mascotaHasLogro->delete();
   
        return response()->json(['message' => 'mascotaHasLogro eliminado correctamente'], 200);
    }

    
    //funcion para mostrar los logros que tiene cada tipo de mascota
   
    public function obtenerLogrosDeMascota($mascotaId)
    {

       $user = Auth::user();
        // Encuentra la información de la mascota por su ID
        $informacionMascota = Informacion::find($mascotaId);

        if (!$informacionMascota) {
            // Si la mascota no existe, puedes manejar el error adecuadamente
            return response()->json(['error' => 'Mascota no encontrada'], 404);
        }

        // Verifica si el usuario autenticado es propietario de la mascota
        if ($informacionMascota->user_id !== Auth::id()) {
            // Si el usuario no es propietario de la mascota, devuelve un mensaje de error
            return response()->json(['error' => 'No tienes permiso para ver los logros de esta mascota'], 403);
        }

        // Utiliza el método logrosAsignados del modelo Informacion para obtener los logros de la mascota
        $logrosAsignados = $informacionMascota->logrosAsignados($mascotaId);

        // Puedes devolver los logros asignados como una respuesta JSON o realizar cualquier otra acción según tus necesidades
        return response()->json($logrosAsignados);
    }


}
