<?php

namespace App\Http\Controllers;

use App\Respuesta;
use App\Pregunta;
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

        $pregunta = [];
        $respuesta = [];
        $pre_id = [];
        $respuesta_total = [];
        $pregunta_total = [];

        $esquema = Esquema::where('esq_id',$request->input('esq'))->get();
        #dd($esquema);
        
        $competencia = Competencia::where('com_esq_id',$request->input('esq'))->get();

        $rand_restrict = rand(1, 2);

        // dd($competencia[1]->com_id);

        foreach ($competencia as $com) {
            #$pregunta = Pregunta::where('pre_com_id', $com->com_id)->inRandomOrder()->take($com->com_cant)->get();
            array_push($pregunta, Pregunta::where('pre_com_id', $com->com_id)->whereIn('pre_restrict',[0,$rand_restrict])->inRandomOrder()->take($com->com_cant)->get());
        }
        #dd($pregunta);
        // dd($pregunta[0]->get(0)->pre_id);
        // dd($pregunta[0][0]->pre_id);

        foreach ($pregunta as $pre) {
            foreach ($pre as $key) {
                array_push($pre_id, $key->pre_id);
            }
        }
        #dd($pre_id);
        foreach ($pre_id as $pre) {
            array_push($respuesta, Respuesta::where('res_pre_id', $pre)->get());
        }
        // dd($respuesta);
        
        foreach ($respuesta as $resCollection) {
            foreach ($resCollection as $res) {
                array_push($respuesta_total, $res);
            }
            
        }

        foreach ($pregunta as $preCollection) {
            foreach ($preCollection as $pre) {
                array_push($pregunta_total, $pre);
            }
            
        }

        #dd($pregunta_total);

        // $pregunta = Pregunta::where('pre_com_id', $competencia->com_id)->get();

        // $respuesta = Respuesta::where('res_pre_id', $pregunta->pre_id)->get();

        $count = 0;

        $wordDoc = new \PhpOffice\PhpWord\PhpWord();

        $fontStyleName = 'rStyle';
        $wordDoc->addFontStyle($fontStyleName, array('bold' => true, 'italic' => true, 'size' => 16, 'allCaps' => true, 'doubleStrikethrough' => true));

        $paragraphStyleName = 'pStyle';
        $wordDoc->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        $wordDoc->addTitleStyle(5, array('bold' => true), array('spaceAfter' => 240, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        //Nueva seccion
        $seccion = $wordDoc->addSection();

        //Texto sin formato
        foreach ($esquema as $esq) {
            $seccion->addTitle('Esquema: '.$esq->esq_name, 5);
        }
        foreach ($competencia as $com) {
            $seccion->addTitle('Competencia: '.$com->com_name, 5);
            foreach ($pregunta_total as $pre){
                $opciones = ['a. ','b. ','c. ','d. '];
                $countOpciones = 0;
                if ($com->com_id == $pre->pre_com_id) {
                    $seccion->addText(++$count.'. '.$pre->pre_content);
                    foreach ($respuesta_total as $res) {
                        if ($res->res_pre_id == $pre->pre_id) {
                            $seccion->addText($opciones[$countOpciones++].$res->res_content);
                        }
                    }
                }
            }
        }
    
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordDoc, 'Word2007');
        try {
            $objWriter->save(storage_path('Documento01.docx'));
        }catch (Exception $e){

        }       

        return response()->download(storage_path('Documento01.docx'));

        return view('generar',[ 
            'esquema' => $esquema,
            'competencia' => $competencia,
            'pregunta' => $pregunta_total,
            'respuesta' => $respuesta_total,
            'restriccion' => $rand_restrict
        ]);
    

        //Para las competencias
        // while ( $i <= 10) {
        //     # code...
        // }
    }

    public function esqComp(Request $request){

        $competencia = Competencia::where('com_esq_id',$request->input('esquema'))->get();

        return view('validar', compact('competencia'));
    }

}
