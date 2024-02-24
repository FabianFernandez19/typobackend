<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota_has_logros;
use App\Models\Informacion;
use App\Models\Logros;

class mascota_has_logrosApiController extends Controller
{


    public function index()
    {
    $mascotaHasLogros = Mascota_has_logros::with('informacion:id,name', 'logros:id,tipoLogro')->get();

    return response()->json($mascotaHasLogros);
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
