<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Esquema;
use App\Respuesta;
use App\Http\Requests\CreateQuestionRequest;
use App\Pregunta;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function mostrarPregunta(Request $competencia){

        //Muestra todas las preguntas
        $pregunta = Pregunta::where('pre_com_id',$competencia->input('competencia'))->get();
        #$respuesta = Respuesta::where('res_pre_id')
        $respuesta = Respuesta::all();
        #dd($pregunta);
        return view('mostrar', [
            'pregunta' => $pregunta,
            'respuesta' => $respuesta
        ]);
    }

    /*public function mostrarPregunta(Request $request){

        //Muestra todas las preguntas
        $pregunta = Pregunta::where('pre_com_id',$request->input('competencia'))->get();  
        dd($pregunta);
        return view('mostrar', [
            'pregunta' => $pregunta
        ]);
    }*/

    public function crearPregunta(CreateQuestionRequest $request){
    	
        //Guarda pregunta en base de datos
    	$pregunta = Pregunta::create([

    		'pre_content'	=> $request->input('pregunta'),
    		#'pre_id' => $request->input('id'),
    		'pre_restrict' => $request->input('restrict'),
    		'pre_com_id' => $request->input('competencia'),
    	]);

        //Para convierte correcta a entero
        if ($request->input('correcta') == 'a') {
            $correctaA = 1;
        }else{
            $correctaA = 0;
        }

        if ($request->input('correcta') == 'b') {
            $correctaB = 1;
        } else {
            $correctaB = 0;
        }

        if ($request->input('correcta') == 'c') {
            $correctaC = 1;
        }else{
            $correctaC = 0;
        }

        if ($request->input('correcta') == 'd') {
            $correctaD = 1;
        }else{
            $correctaD = 0;
        }
        
        //Obtiene el ultimo id de pregunta añadido para agregarle como llave foranea a respuesta
        $res_pre_id = Pregunta::max('pre_id');

        //Guarda las respuestas
        $respuestaA = Respuesta::create([

            'res_content'   => $request->input('respuestaA'),
            'res_correct' => $correctaA,
            'res_pre_id' => $res_pre_id
        ]);

        $respuestaB = Respuesta::create([

            'res_content'   => $request->input('respuestaB'),
            'res_correct' => $correctaB,
            'res_pre_id' => $res_pre_id
        ]);

        $respuestaC = Respuesta::create([

            'res_content'   => $request->input('respuestaC'),
            'res_correct' => $correctaC,
            'res_pre_id' => $res_pre_id
        ]);

        $respuestaD = Respuesta::create([

            'res_content'   => $request->input('respuestaD'),
            'res_correct' => $correctaD,
            'res_pre_id' => $res_pre_id
        ]);

    	return redirect('/');
    }

    public function modificarPregunta(Request $request){

        $pregunta = Pregunta::where('pre_id',$request->input('editar'))->get();

        $respuesta = Respuesta::where('res_pre_id',$request->input('editar'))->get();

        $esquema = Esquema::all();
        $competencia = Competencia::all();

        #$editar = $request->input('editar');

        #dd($respuesta);

        return view('modificar',[
            'pregunta' => $pregunta,
            'respuesta' => $respuesta,
            'esquema' => $esquema,
            'competencia' => $competencia
        ]);
    }

    public function guardarModificacion(Request $request){

        //Guarda pregunta en base de datos
        $pregunta = Pregunta::where('pre_id',$request->input('id'))->update([

            'pre_content'   => $request->input('pregunta'),
            #'pre_id' => $request->input('id'),
            'pre_restrict' => $request->input('restrict'),
            'pre_com_id' => $request->input('competencia'),
        ]);

        //Para convierte correcta a entero
        if ($request->input('correcta') == 'a') {
            $correctaA = 1;
        }else{
            $correctaA = 0;
        }

        if ($request->input('correcta') == 'b') {
            $correctaB = 1;
        } else {
            $correctaB = 0;
        }

        if ($request->input('correcta') == 'c') {
            $correctaC = 1;
        }else{
            $correctaC = 0;
        }

        if ($request->input('correcta') == 'd') {
            $correctaD = 1;
        }else{
            $correctaD = 0;
        }
        
        //Obtiene el ultimo id de pregunta añadido para agregarle como llave foranea a respuesta
        $res_pre_id = $request->input('id');

        //Guarda las respuestas
        $respuestaA = Respuesta::where('res_id',$request->input('res_idA'))->update([

            'res_content'   => $request->input('respuestaA'),
            'res_correct' => $correctaA,
            'res_pre_id' => $res_pre_id
        ]);

        $respuestaB = Respuesta::where('res_id',$request->input('res_idB'))->update([

            'res_content'   => $request->input('respuestaB'),
            'res_correct' => $correctaB,
            'res_pre_id' => $res_pre_id
        ]);

        $respuestaC = Respuesta::where('res_id',$request->input('res_idC'))->update([

            'res_content'   => $request->input('respuestaC'),
            'res_correct' => $correctaC,
            'res_pre_id' => $res_pre_id
        ]);

        $respuestaD = Respuesta::where('res_id',$request->input('res_idD'))->update([

            'res_content'   => $request->input('respuestaD'),
            'res_correct' => $correctaD,
            'res_pre_id' => $res_pre_id
        ]);

        return redirect('/');
    }

    public function borrarPregunta(Request $request){

        $borrarRespuestas = Respuesta::where('res_pre_id',$request->input('borrar'))->delete();
        $borrar = Pregunta::where('pre_id',$request->input('borrar'))->delete();

        return redirect('/');
    }
}