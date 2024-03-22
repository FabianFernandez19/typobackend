<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Informacion;
use App\Models\Agendamiento;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InformacionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $informacion = Informacion::where('user_id', $user->id)->get();
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
        $user = Auth::user();
        if ($informacion->user_id == $user->id) {
            return response()->json($informacion, 200);
        } else {
            return response()->json(['message' => 'Informacion de Mascoto es privada'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {      
        $user = Auth::user();
         
  // Obtener el usuario autenticado
    $user = Auth::user(); 
    // Buscar la información de la mascota por su ID
    $informacion = Informacion::find($id);
    // Verificar si la información de la mascota existe
    if (!$informacion) {
        return response()->json(['mensaje' => 'Información de la mascota no encontrada'], 404);
    }
    // Verificar si el usuario autenticado es el propietario de la mascota
    if ($informacion->user_id !== $user->id) {
        return response()->json(['mensaje' => 'No tienes permiso para actualizar esta mascota'], 403);
    }
    // Actualizar la información de la mascota con los datos recibidos en la solicitud
    $informacion->update([
        'Nombre_Mascota' => $request->Nombre_Mascota,
        'Edad' => $request->Edad,
        'Raza' => $request->Raza,
        'Peso' => $request->Peso,
        'Tamaño' => $request->Tamaño,
        'Sexo' => $request->Sexo,
        'tiempo_total' => $request->tiempo_total,
        'id_tipomascota' => $request->id_tipomascota,
    ]);
    // Devolver la información de la mascota actualizada en formato JSON con el código de estado 200 (OK)
    return response()->json($informacion, 200);
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



    



    

   
   



