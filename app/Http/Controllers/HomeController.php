<?php

namespace App\Http\Controllers;

use App\Respuesta;
use App\Pregunta;
use App\Competencia;
use App\Esquema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $esquema = Esquema::all();
        
        return view('welcome',[
            'esquema' => $esquema
        ]);
        // return view('home');
    }
}
