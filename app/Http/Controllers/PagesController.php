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
        
        
        $competencia = Competencia::where('com_esq_id',$request->input('esq'))->get();

        $rand_restrict = rand(1, 2);

        foreach ($competencia as $com) {
            #$pregunta = Pregunta::where('pre_com_id', $com->com_id)->inRandomOrder()->take($com->com_cant)->get();
            array_push($pregunta, Pregunta::where('pre_com_id', $com->com_id)->whereIn('pre_restrict',[0,$rand_restrict])->inRandomOrder()->take($com->com_cant)->get());
        }

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

        // $pregunta = Pregunta::where('pre_com_id', $competencia->com_id)->get();

        // $respuesta = Respuesta::where('res_pre_id', $pregunta->pre_id)->get();

        //Para generar documento en word
        $count = 0;

        $wordDoc = new \PhpOffice\PhpWord\PhpWord();

        //Para el encabezado
        $seccion = $wordDoc->addSection();

        $header = $seccion->addHeader();

        //estilos tabla
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 1, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');

        $spanTableStyleName = 'Colspan Rowspan';
        $wordDoc->addTableStyle($spanTableStyleName, $fancyTableStyle);

        //Creacion de tabla
        $table = $header->addTable($spanTableStyleName);
        $table->addRow();
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $image = $cell1->addTextRun();
        $image->addImage(storage_path('onicert.png'),  array('width' => 148, 'height' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        $cell2 = $table->addCell(4000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Examen de conocimiento esquema '.$esquema[0]->esq_name);

        
        $table->addCell(2000, $cellVCentered)->addText('version', null, $cellHCentered);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellVCentered)->addText('vigencia', null, $cellHCentered);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(4000, $cellRowSpan)->addText('Certificación de competencias profesionales en RETIE', null, $cellHCentered);

        $table->addCell(2000, $cellVCentered)->addText('codigo: '.$esquema[0]->esq_id, null, $cellHCentered);


        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        // $table->addCell(2000, $cellHCentered)->addText('prueba');
        // $table->addCell(2000, $cellHCentered)->addText('paginas');
        $table->addCell(2000, $cellVCentered, $cellHCentered)->addPreserveText('Pagina {PAGE} de {NUMPAGES}');

        //Footer
        $footer = $seccion->addFooter();
        $footer->addImage(storage_path('footer.png'), array('width' => 50, 'height' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));

        //seccion de preguntas y respuestas
        $seccion->addTextBreak();

        $fontStyleName = 'rStyle';
        $wordDoc->addFontStyle($fontStyleName, array('bold' => true, 'italic' => true, 'size' => 16, 'allCaps' => true, 'doubleStrikethrough' => true));

        $paragraphStyleName = 'pStyle';
        $wordDoc->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        $wordDoc->addTitleStyle(5, array('bold' => true), array('spaceAfter' => 240, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        //Preguntas y respuestas
        $seccion->addTitle('PREGUNTAS DE SELECCIÓN MÚLTIPLE CON ÚNICA RESPUESTA', 5);
        $seccion->addTextBreak();
        
        foreach ($competencia as $com) {
            $seccion->addTitle($com->com_name, 5);
            // $seccion->addTextBreak();
            foreach ($pregunta_total as $pre){
                $opciones = ['a. ','b. ','c. ','d. '];
                $countOpciones = 0;
                if ($com->com_id == $pre->pre_com_id) {
                    $seccion->addText(++$count.'. '.$pre->pre_content);
                    $seccion->addTextBreak();
                    foreach ($respuesta_total as $res) {
                        if ($res->res_pre_id == $pre->pre_id) {
                            $seccion->addText($opciones[$countOpciones++].$res->res_content, null, array('indentation' => array('left' => 1000, 'right' => 100)));
                        }
                    }
                }
                $seccion->addTextBreak();
            }
        }

        //Para generar documento a partir de plantilla

        /*$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('plantilla.docx'));

        $count = 0;

        $cantEsquema = count($esquema);
        $cantCompetencia = count($competencia);
        $cantPregunta = count($pregunta_total);
        $cantRespuesta = count($respuesta_total);

        $contenido = '';
        
        $templateProcessor->cloneRow('competencia', 7);

        for ($esq = 0 ; $esq < $cantEsquema; $esq++) {
            $templateProcessor->setValue('titulo', 'Esquema: '.$esquema[$esq]->esq_name);
        }
        for ($com = 0 ; $com < $cantCompetencia; $com++) {
            $contenido = $contenido.$competencia[$com]->com_name."<br>" ;
            $templateProcessor->setValue('competencia#'.$com, 'Competencia: '.$competencia[$com]->com_name);
            for ($pre = 0 ; $pre < $cantPregunta; $pre++){
                $templateProcessor->cloneRow('pregunta', $cantPregunta);
                $opciones = ['a. ','b. ','c. ','d. '];
                $countOpciones = 0;
                if ($competencia[$com]->com_id == $pregunta_total[$pre]->pre_com_id) {
                    $templateProcessor->setValue('pregunta#'.$pre, ++$count.'. '.$pregunta_total[$pre]->pre_content);
                    for ($res = 0 ; $res < $cantRespuesta; $res++) {
                        $templateProcessor->cloneRow('respuesta', $cantRespuesta);
                        if ($respuesta_total[$res]->res_pre_id == $pregunta_total[$pre]->pre_id) {
                            $templateProcessor->setValue('respuesta#'.$res, $opciones[$countOpciones++].$respuesta_total[$res]->res_content);
                        }
                    }
                }
            }
        }

        $templateProcessor->setValue('contenido', $seccion);

        $templateProcessor->saveAs(storage_path('Documento01.docx'));*/

        //Para generar respuestas
        $count = 0;

        $respuestaDoc = new \PhpOffice\PhpWord\PhpWord();

        //Para el encabezado
        $seccion = $respuestaDoc->addSection();

        $header = $seccion->addHeader();

        //Estilos de la tabla del encabezado
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 1, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');

        $spanTableStyleName = 'Colspan Rowspan';
        $respuestaDoc->addTableStyle($spanTableStyleName, $fancyTableStyle);

        $table = $header->addTable($spanTableStyleName);
        $table->addRow();
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $image = $cell1->addTextRun();
        $image->addImage(storage_path('onicert.png'),  array('width' => 148, 'height' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        $cell2 = $table->addCell(4000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Respuestas examen de conocimiento esquema '.$esquema[0]->esq_name);

        
        $table->addCell(2000, $cellVCentered)->addText('version', null, $cellHCentered);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellVCentered)->addText('vigencia', null, $cellHCentered);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(4000, $cellRowSpan)->addText('Certificación de competencias profesionales en RETIE', null, $cellHCentered);
        // $table->addCell(2000, $cellVCentered)->addText('D', null, $cellHCentered);
        // $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellVCentered)->addText('codigo: '.$esquema[0]->esq_id, null, $cellHCentered);

        // $paginas = $header->addPreserveText('Page {PAGE} of {NUMPAGES}');

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        // $table->addCell(2000, $cellHCentered)->addText('prueba');
        // $table->addCell(2000, $cellHCentered)->addText('paginas');
        $table->addCell(2000, $cellVCentered, $cellHCentered)->addPreserveText('Pagina {PAGE} de {NUMPAGES}');

        //Footer
        $footer = $seccion->addFooter();
        $footer->addImage(storage_path('footer.png'), array('width' => 50, 'height' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));

        $seccion->addTextBreak();

        //Para tabla de respuestas
        $fontStyleName = 'rStyle';
        $respuestaDoc->addFontStyle($fontStyleName, array('bold' => true, 'italic' => true, 'size' => 16, 'allCaps' => true, 'doubleStrikethrough' => true));

        $paragraphStyleName = 'pStyle';
        $respuestaDoc->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        $respuestaDoc->addTitleStyle(5, array('bold' => true), array('spaceAfter' => 240, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        //para tabla de nombre
        $table = $seccion->addTable(array('borderSize' => 6, 'borderColor' => '000000'));

        $table->addRow();
        $table->addCell(3000, array('gridSpan' => '2', 'valign' => 'center'))->addText('NOMBRES Y APELLIDOS');
        $table->addCell(7000, array('gridSpan' => '4', 'valign' => 'center'));

        $table->addRow();
        $table->addCell(1000)->addText('CEDULA');
        $table->addCell(1500);
        $table->addCell(1500)->addText('FECHA');
        $table->addCell(2500);
        $table->addCell(2000)->addText('CODIGO EXAMEN');
        $table->addCell(1500);

        
        $seccion->addTextBreak();
        
        //Imagen
        $seccion->addImage(storage_path('respuesta.png'), array('width' => 410, 'height' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));

        //Tabla de respuestas
        $table = $seccion->addTable(array('borderSize' => 6, 'borderColor' => '000000'));

        $table->addRow(300);
        $table->addCell(350, array('vMerge' => 'restart', 'valign' => 'center','borderColor' => 'FFFFFF'));
        $table->addCell(350, array('gridSpan' => 4, 'valign' => 'center'));
        $table->addCell(350, array('vMerge' => 'restart', 'valign' => 'center', 'borderColor' => 'FFFFFF'));
        $table->addCell(350, array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '999999', 'borderColor' => 'FFFFFF', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR))->addText('Supervisor', array('size' => 8));
        $table->addCell(350, array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '999999', 'borderColor' => 'FFFFFF', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR))->addText('revisión', array('size' => 8));

        $table->addRow(150);
        $table->addCell(null, array('vMerge' => 'continue'));
        $table->addCell()->addText('A');
        $table->addCell()->addText('B');
        $table->addCell()->addText('C');
        $table->addCell()->addText('D');
        $table->addCell(null, array('vMerge' => 'continue'));
        $table->addCell(null, array('vMerge' => 'continue'));
        $table->addCell(null, array('vMerge' => 'continue'));
        
        foreach ($esquema as $esq) {
            // $seccion->addTitle('Esquema: '.$esq->esq_name, 5);
        }
        foreach ($competencia as $com) {
            // $seccion->addTitle('Competencia: '.$com->com_name, 5);
            foreach ($pregunta_total as $pre){
                $opciones = ['a.png','b.png','c.png','d.png'];
                $countOpciones = 0;
                if ($com->com_id == $pre->pre_com_id) {
                    $table->addRow(300);
                    $table->addCell(350)->addText(++$count);
                    foreach ($respuesta_total as $res) {
                        if ($res->res_pre_id == $pre->pre_id) {
                            if ($res->res_correct == 1) {
                                $table->addCell(350, array('bgColor' => '000000'));
                                $countOpciones++;
                            }else{
                                $table->addCell(350)->addImage(storage_path($opciones[$countOpciones++]),  array('width' => 10, 'height' => 10, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
                            }
                        }
                    }
                    $table->addCell(350);
                    $table->addCell(350, array('bgColor' => '999999'));
                    $table->addCell(350, array('bgColor' => '999999'));
                }
            }
        }


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordDoc, 'Word2007');
        $objWriterRespuesta = \PhpOffice\PhpWord\IOFactory::createWriter($respuestaDoc, 'Word2007');
        try {
            $objWriter->save(storage_path('pregunta_'.$esquema[0]->esq_id.'.docx'));
            $objWriterRespuesta->save(storage_path('respuesta_'.$esquema[0]->esq_id.'.docx'));
            $pregunta_doc = 'pregunta_'.$esquema[0]->esq_id.'.docx';
            $respuesta_doc = 'respuesta_'.$esquema[0]->esq_id.'.docx';
        }catch (Exception $e){

        }       

        // return  response()->download(storage_path('Documento01.docx'));

        return view('generar',[ 
            'esquema' => $esquema,
            'competencia' => $competencia,
            'pregunta' => $pregunta_total,
            'respuesta' => $respuesta_total,
            'restriccion' => $rand_restrict,
            'pregunta_doc' => $pregunta_doc,
            'respuesta_doc' => $respuesta_doc
        ]);
    
    }

    public function esqComp(Request $request){

        $competencia = Competencia::where('com_esq_id',$request->input('esquema'))->get();

        return view('validar', compact('competencia'));
    }

    public function generarWordPregunta(Request $request){
        return  response()->download(storage_path($request->input('pre_doc')));
    }

    public function generarWordRespuesta(Request $request){
        return  response()->download(storage_path($request->input('res_doc')));
    }
}
