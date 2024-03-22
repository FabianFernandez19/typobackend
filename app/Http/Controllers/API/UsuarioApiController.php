<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos
use App\Models\User;
use App\Models\Agendamiento;
use App\Models\Informacion;
use Spatie\Permission\Models\Role;
use Iluminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Iluminate\Support\Arr;

class UsuarioApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::all();
        return response()->json($usuario, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|same:confirm-password',
        'roles' => 'required'
    ]);

    // Hash::make en lugar de Iluminate\Support\Facades\Hash::make
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);

    // Elimina esta línea si no necesitas crear el usuario de esta manera
    // $user = User::create($input);

    // Asegúrate de que el usuario se crea solo si no existe
    $user = User::firstOrNew(['email' => $input['email']]);
    $user->fill($input)->save();

    // Asignar roles si existen
    $roles = $request->input('roles');
    if ($roles) {
        $existingRoles = Role::whereIn('name', $roles)->get();
        $user->syncRoles($existingRoles);
    }
    return response()->json(['success' => 'User created successfully']);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->validate($request, [
            'user.name' => 'sometimes|required',
            'user.apellido' => 'sometimes|required',
            'user.telefono' => 'sometimes|required',
            'user.fecha_nacimiento' => 'sometimes|required',
            'user.email' => 'sometimes|required',
            'user.password' => 'sometimes|same:user.confirm-password',
            'user.roles' => 'sometimes|required'
        ]);        

            $input = $request->all();
            if (!empty($input['password'])){
                $input['password'] = Hash::make($input['password']);
            }else{
                unset($input['password']);
            }

            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();

            $user->assignRole($request->input('roles'));
            return response()->json(['success' => 'User update successfully']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'User delete successfully']);
    }


    public function obtenerTiempoTotal($userId)
    {
        $tiempoTotal = Agendamiento::whereHas('informacion', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('tiempo_asignado_actividad');

        $usuario = User::find($userId);

        if ($usuario) {
            $usuario->tiempo_total = $tiempoTotal;
            $usuario->save();

            return response()->json(['message' => 'Tiempo total actualizado correctamente', 'tiempo_total' => $tiempoTotal], 200);
        } else {
            return response()->json(['error' => 'El usuario no se encontró'], 404);
        }
    }





    //FUNCION PARA RECUPERAR LA INFORMACION RELEVANTE DEL USUARIO

   /* public function obtenerInformacionUsuario($id)
    {
        // Buscar al usuario por su ID
        $usuario = User::findOrFail($id);
    
        // Obtener todas las mascotas del usuario
        $mascotas = $usuario->informaciones;
    
        // Inicializar arrays para almacenar la información de todas las mascotas
        $agendamientos = [];
        $logrosMascotas = [];
        $reportesCumplimiento = [];
    
        // Iterar sobre cada mascota del usuario
        foreach ($mascotas as $mascota) {
            // Obtener los agendamientos de la mascota actual
            $agendamientosMascota = $mascota->agendamientos;
    
            // Agregar los agendamientos de la mascota actual al array general
            $agendamientos = array_merge($agendamientos, $agendamientosMascota->toArray());
    
            // Verificar si la relación de logros está definida para la mascota actual
            if ($mascota->logros) {
                // Obtener los logros asignados a la mascota actual
                $logrosMascota = $mascota->logros;
    
                // Agregar los logros de la mascota actual al array general
                $logrosMascotas[] = $logrosMascota->toArray();
            }
    
            // Verificar si la relación de reporte_cumplimiento está definida para la mascota actual
            if ($mascota->reporte_cumplimiento) {
                // Obtener el reporte de cumplimiento del usuario para la mascota actual
                $reporteCumplimiento = $mascota->reporte_cumplimiento;
    
                // Agregar el reporte de cumplimiento de la mascota actual al array general
                $reportesCumplimiento[] = $reporteCumplimiento->toArray();
            }
        }
    
        // Devolver los datos obtenidos como respuesta
        return response()->json([
            'usuario' => $usuario,
            'mascotas' => $mascotas,
            'agendamientos' => $agendamientos,
            'logros_mascotas' => $logrosMascotas,
            'reportes_cumplimiento' => $reportesCumplimiento
        ], 200);
    }*/

    public function obtenerInformacionUsuario($id)
{
    $usuario = User::findOrFail($id);    
    

    // Obtener todas las mascotas asociadas al usuario con sus agendamientos y logros
    $mascotas = $usuario->informaciones()->with(['agendamientos', 'logros'])->get();

    // Obtener el reporte de cumplimiento del usuario
    $reporteCumplimiento = $usuario->reporteCumplimiento;

    return response()->json([
        'usuario' => $usuario,
        'mascotas' => $mascotas,
        'reporte_cumplimiento' => $reporteCumplimiento
    ], 200);
}









}
