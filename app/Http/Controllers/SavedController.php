<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\savedEvents;

class SavedController extends Controller
{
    public function index($userId){
        //$saved = SavedEvents::orderBy("created_at","desc")->paginate(10);
        $saved = SavedEvents::where("userId", "=", $userId)->get();
        return response()->json($saved);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'eventId' => 'required|string',
                'userId' => 'required|integer',
            ]);
            $saved = new SavedEvents();
            $saved->userId = $request->input('userId');
            $saved->eventId = $request->input('eventId');
            $saved->save();
            return response()->json($saved,201);
        }
        catch(\Exception $e) {
            return response()->json(['error' => 'Error en el formato de la request'], 500);
        }
    }

    public function destroy(Request $request, $id) {
        $user = $request->user('api');
        if(!$user) {
            return response()->json(['error'=> 'Unauthorized'],403);
        }
        $saved = SavedEvents::where("id", "=", $id)->where("userId", "=", $user->id);
        if(!$saved->count()){
            return response()->json(['message'=> 'El evento guardado no existe'],404);
        }
        $saved->delete();
        return response()->json(['message'=> ''],200);
    }
}
