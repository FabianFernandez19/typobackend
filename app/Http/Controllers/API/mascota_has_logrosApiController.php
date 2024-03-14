<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota_has_logros;
use App\Models\Informacion;
use App\Models\Logros;

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
   


}
