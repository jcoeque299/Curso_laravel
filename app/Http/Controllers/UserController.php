<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $user = User::orderBy("created_at","desc")->paginate(10);
        return response()->json($user);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $user = new User();
            $user->commentText = $request->input('name');
            $user->eventId = $request->input('email');
            $user->userId = $request->input('password');
            $user->save();
            return response()->json($user,201);
        }
        catch(\Exception $e) {
            return response()->json(['error' => 'Error en el formato de la request'], 500);
        }
    }

    public function destroy($id) {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=> 'El usuario no existe'],404);
        }
        $user->delete();
        return response()->json(['message'=> ''],200);
    }
}
