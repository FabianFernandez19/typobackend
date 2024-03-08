<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Informacion;
use App\Models\Agendamiento;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InformacionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informacion = Informacion::all();
        return response()->json($informacion, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $informacion = new Informacion();
            //$informacion->Id_Tipo_Mascota =$request->Id_Tipo_Mascota;
            $informacion->Nombre_Mascota =$request->Nombre_Mascota;
            $informacion->Edad =$request->Edad;
            $informacion->Raza =$request->Raza;
            $informacion->Peso =$request->Peso;
            $informacion->Tamaño =$request->Tamaño;
            $informacion->Sexo =$request->Sexo;
           // $informacion->tiempo_total =$request->tiempoTotal;
           $informacion->tiempo_total = $request->tiempo_total;
            $informacion->user_id =$request->user_id;
            $informacion->id_tipomascota =$request->id_tipomascota;
            $informacion->save();
            return response()->json($informacion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $informacion = Informacion::find($id);
        return response()->json($informacion,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
            $informacion = Informacion::find($id);
            //$informacion->Id_Mascota =$request->Id_Mascota;
            $informacion->Nombre_Mascota =$request->Nombre_Mascota;
            $informacion->Edad =$request->Edad;
            $informacion->Raza =$request->Raza;
            $informacion->Peso =$request->Peso;
            $informacion->Tamaño =$request->Tamaño;
            $informacion->Sexo =$request->Sexo;
            $informacion->tiempoTotal =$request->tiempoTotal;
            $informacion->user_id =$request->user_id;
            $informacion->id_tipomascota =$request->id_tipomascota;
            $informacion->user_id =$request->user_id;
            $informacion->update();
            return response()->json($informacion, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $informacion = Informacion::find($id);
        if($informacion){
        $informacion->delete();
        return response()->json($informacion, 200);
    }else{
        return response()->json(['message' => 'Informacion de Mascoto no encontrada'], 404);
    }
    }

    /**
     *
     * Metodo para traer las mascotas de un usuario
     */

    public function getMascotasByUserId($id)
    {
        $informacion = DB::table("informacion")->where("user_id", "=", $id)->get();
        if (!$informacion) {
            return response()->json(['message' => 'Informacion de Mascoto no encontrada'], 404);
        }
        return response()->json($informacion, 200);
    }

    

   
   


}
