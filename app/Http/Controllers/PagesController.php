<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Esquema;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(){
    	//Pagina de inicio
        $esquema = Esquema::all();
        
    	return view('welcome',[
            'esquema' => $esquema
        ]);
    }

    public function admin(){
    	
    	//Pagina Admin
    	$esquema = Esquema::all();
    	$competencia = Competencia::all();

    	/*foreach ($esquemas as $esquema) {
    		
    	}*/
    	#dd($esquema);

    	return view('admin',[
    		'esquema' => $esquema,
    		'competencia' => $competencia
    	]);
    }

    public function generarExamen(Request $request){

        $esquema = Esquema::where('esq_id',$request->input('esq'))->get();
        dd($esquema);
        return view('generar',[ 
            'esquema' => $esquema
        ]);

        

        //Para las competencias
        // while ( $i <= 10) {
        //     # code...
        // }
    }

}
