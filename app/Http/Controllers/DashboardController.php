<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $eventos = Evento::all();
        return view('dashboard',compact('eventos'));
    }
}
