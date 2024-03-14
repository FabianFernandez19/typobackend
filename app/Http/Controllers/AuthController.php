<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'apellido' => 'required|string',
            'telefono' => 'required|integer',
            'fecha_nacimiento' => 'required|date',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user =
        User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Asignación del rol
        $user->assignRole('User');

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }
  
    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->name =$request->name;
        $users->apellido =$request->apellido;
        $users->telefono =$request->telefono;
        $users->fecha_nacimiento =$request->fecha_nacimiento;
        $users->email =$request->email;
        $users->update();
        return response()->json($users, 200);
    }

    public function signUpadmin(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        Admin::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellido' => $request ->apellido,
            'telefono' => $request ->telefono,
            'fecha_nacimiento' =>$request ->fecha_nacimiento,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Asignación del rol

        $user->assignRole('Administrator');

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }


}

