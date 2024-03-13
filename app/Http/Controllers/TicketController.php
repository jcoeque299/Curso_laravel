<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tickets;

class TicketController extends Controller
{
    public function index(){
        $ticket = Tickets::orderBy("created_at","desc")->paginate(10);
        return response()->json($ticket);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'contactEmail' => 'required|string',
                'text' => 'required|string'
            ]);
            $ticket = new Tickets();
            $ticket->contactEmail = $request->input('contactEmail');
            $ticket->text = $request->input('text');
            $ticket->save();
            return response()->json($ticket,201);
        }
        catch(\Exception $e) {
            return response()->json(['error' => 'Error en el formato de la request'], 500);
        }
    }

    public function destroy($id) {
        $ticket = Tickets::find($id);
        if(!$ticket){
            return response()->json(['message'=> 'El ticket guardado no existe'],404);
        }
        $ticket->delete();
        return response()->json(['message'=> ''],200);
    }
}
