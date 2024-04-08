<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comments;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index($eventId){
        $comments = DB::table("comments")->join("users", "users.id", "comments.userId")->select("comments.commentText", "users.name")->where("eventId", "=", $eventId)->get();
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
