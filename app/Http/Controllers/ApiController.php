<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comments;

class ApiController extends Controller
{
    public function index($eventId){
        //Por algun motivo, solo el primer registro de un comentario enviado desde la pagina, despues de hacer un migrate refresh, incluye todo el objeto user
        $comments = Comments::where("eventId", "=", $eventId)->get();
        //$comments = Comments::with("user:id,name")->get();
        //$comments = $comments::orderBy("created_at","desc")->paginate(10);
        return response()->json($comments);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'commentText' => 'required|string',
                'userId' => 'required|integer',
                'eventId' => 'required|string'
            ]);
            $comment = new comments();
            $comment->commentText = $request->input('commentText');
            $comment->eventId = $request->input('eventId');
            $comment->userId = $request->input('userId');
            $comment->save();
            return response()->json($comment,201);
        }
        catch(\Exception $e) {
            return response()->json(['error' => 'Error en el formato de la request'], 500);
        }
    }

    public function destroy($id) {
        $comment = comments::find($id);
        if(!$comment){
            return response()->json(['message'=> 'El comentario no existe'],404);
        }
        $comment->delete();
        return response()->json(['message'=> ''],200);
    }
}
