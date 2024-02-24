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
        $this->validate($request,[
            'name'=>'required',
            'email' =>'required|email|uniqued:users,email'.id,
            'password'=>'same:confirm-password',
            'roles'=>'required'
            ]);

            $input = $request->all();
            if (!empty($input['password'])){
                $input['password'] = Hash::make($input['password']);
            }else{
                $input = Arr::except($input, array('password'));
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







}
