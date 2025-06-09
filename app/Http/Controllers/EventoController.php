<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index(Request $request){
        $eventos = Evento::all();
        return view('evento.index',compact('eventos'));
    }
    public function store(Request $request){
        $evento = new Evento();
        $evento->nombre = $request->nombre;
        $evento->descripción = $request->descripción;
        $evento->save();
        
        return redirect()->route('evento.index')->with('succcess','Evento creado Exitosamente');
    }
    public function update(Request $request, $id){
        $evento = Evento::find($id);
        $evento->nombre = $request->nombre;
        $evento->descripción = $request->descripción;
        $evento->save();
        return redirect()->route('evento.index')->with('success','evento modificado exitosamente');
    }
}
