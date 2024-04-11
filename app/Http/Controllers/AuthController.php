<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register (Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'location' => 'required|string'
        ]);
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location
        ]);
        $date = new DateTime("NOW");
        $date->modify("+1 day");
        $token = $user->createToken('authToken',["*"],$date)->plainTextToken;
        return response()->json(['message' => 'Usuario registrado', 'token' => $token, 'statusCode' => 200],200);
    }

    public function login (Request $request) {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $date = new DateTime("NOW");
            $date->modify("+1 day");
            $token = $user->createToken('authToken',["*"],$date)->plainTextToken;
            return response()->json(['message'=> 'Login OK', 'token' => $token, 'statusCode' => 200],200);
        }
        else{
            return response()->json(['message'=> 'Login error', 'statusCode' => 401],401);
        }
    }

    public function user(Request $request) {
        $user = $request->user();

        if($user) {
            return response()->json([
                'id' =>$user->id,
                'name' => $user->name,
                'email' => $user->email,
                'location' => $user->location
            ]);
        }
        else {
            return response()->json(['message'=> 'Usuario no autenticado', 'statusCode' => 401],401);
        }
    }

    //Eliminar
    public function getRole(Request $request) {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'role' =>$user->role
            ]);
        }
        else {
            return response()->json(['message'=> 'Usuario no autenticado', 'statusCode' => 401],401);
        }
    }

    public function logout(Request $request) {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json(['message'=> 'Se ha cerrado sesion', 'statusCode' => 200], 200);
    }
}
