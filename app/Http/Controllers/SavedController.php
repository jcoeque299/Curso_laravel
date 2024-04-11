<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\savedEvents;

class SavedController extends Controller
{
    public function index($userId){
        $saved = SavedEvents::where("userId", "=", $userId)->get();
        return response()->json($saved);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'eventId' => 'required|string',
                'eventName' => 'required|string',
                'eventImageSource' => 'required|string',
                'userId' => 'required|integer',
            ]);
            $isSaved = SavedEvents::where("eventId", "=", $request->input('eventId'))->where("userId", "=", $request->input('userId'));
            if ($isSaved->count()) {
                return response()->json(['message' => 'El evento ya esta guardado', 'statusCode' => 409], 409);
            }
            $saved = new SavedEvents();
            $saved->userId = $request->input('userId');
            $saved->eventId = $request->input('eventId');
            $saved->eventName = $request->input('eventName');
            $saved->eventImageSource = $request->input('eventImageSource');
            $saved->save();
            return response()->json($saved,201);
        }
        catch(\Exception $e) {
            return response()->json(['error' => 'Error en el formato de la request', 'statusCode' => 400], 400);
        }
    }

    public function destroy(Request $request, $id) {
        $user = $request->user('api');
        if(!$user) {
            return response()->json(['error'=> 'Unauthorized'],403);
        }
        $saved = SavedEvents::where("id", "=", $id)->where("userId", "=", $user->id);
        if(!$saved->count()){
            return response()->json(['message'=> 'El evento guardado no existe', 'statusCode' => 404],404);
        }
        $saved->delete();
        return response()->json(['message'=> 'El evento ha sido borrado', 'statusCode' => 200],200);
    }
}
