<?php
//**************************************************************/
//* File:       rContablesController.php
//* Proyecto:   Sistema SISCOVIN_ONGS.V1 Coordinación de vinculación
//¨Función:     Clases para el modulo de requisitos Contables
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: diciembre 2021
//* @Derechos reservados. Gobierno del Estado de México
//*************************************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\reqcontablesRequest;
use App\regOscModel;
use App\regBitacoraModel;
use App\regPfiscalesModel;
use App\regReqContablesModel;
use App\regPerModel;
use App\regNumerosModel;
use App\regFormatosModel;

// Exportar a excel 
use Maatwebsite\Excel\Facades\Excel;

// Exportar a pdf
use PDF;
//use Options;

class rContablesController extends Controller
{

    //******** Buscar requisitos contables *****//
    public function actionBuscarReqc(Request $request){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regperiodicidad= regPerModel::select('PER_ID','PER_DESC')->orderBy('PER_ID','asc')
                        ->get();                          
        $regnumeros   = regNumerosModel::select('NUM_ID','NUM_DESC')->get();
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID','PERIODO_DESC')->get();        
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $fper    = $request->get('fper');   
        $idd     = $request->get('idd');  
        $nameiap = $request->get('nameiap');                  
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){   
            $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')
                            ->get();                                      
            $regcontable  = regReqContablesModel::join('ONGS','ONGS.OSC_ID','=','ONG_REQ_CONTABLES.OSC_ID')
                            ->select( 'ONGS.OSC_DESC','ONG_REQ_CONTABLES.*')
                            ->orderBy('ONG_REQ_CONTABLES.PERIODO_ID','ASC')
                            ->orderBy('ONG_REQ_CONTABLES.OSC_ID'    ,'ASC')                            
                            ->orderBy('ONG_REQ_CONTABLES.OSC_FOLIO' ,'ASC')
                            ->fper($fper)           //Metodos personalizados es equvalente a ->where('OSC_DESC', 'LIKE', "%$name%");
                            ->idd($idd)             //Metodos personalizados  
                            ->nameiap($nameiap)     //Metodos personalizados                                                                                                            
                            ->paginate(30);
        }else{  
            $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')
                            ->where('OSC_ID',$arbol_id)
                            ->get();                                  
            $regcontable  = regReqContablesModel::join('ONGS','ONGS.OSC_ID','=','ONG_REQ_CONTABLES.OSC_ID')
                            ->select( 'ONGS.OSC_DESC','ONG_REQ_CONTABLES.*')
                            ->where(  'ONG_REQ_CONTABLES.OSC_ID'    ,$arbol_id)
                            ->orderBy('ONG_REQ_CONTABLES.PERIODO_ID','ASC')
                            ->orderBy('ONG_REQ_CONTABLES.OSC_ID'    ,'ASC')
                            ->orderBy('ONG_REQ_CONTABLES.OSC_FOLIO' ,'ASC') 
                            ->fper($fper)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                            ->idd($idd)             //Metodos personalizados
                            ->nameiap($nameiap)     //Metodos personalizados                                                                               
                            ->paginate(30);            
        }
        if($regcontable->count() <= 0){ 
            toastr()->error('No existen requisitos contables.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.requisitos.verReqc',compact('nombre','usuario','regosc','regperiodicidad','regnumeros', 'regperiodos','regcontable','regformatos'));
    }

    //******** Mostrar requisitos contables *****//
    public function actionVerReqc(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regperiodicidad= regPerModel::select('PER_ID','PER_DESC')->orderBy('PER_ID','asc')
                        ->get();                          
        $regnumeros   = regNumerosModel::select('NUM_ID','NUM_DESC')->get();
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID','PERIODO_DESC')->get();        
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->get();
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){        
            $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                            'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                            'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                            'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                            'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                            'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',                 
                            'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                            'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                            'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                            'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                            'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                            'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                            'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                            ->orderBy('OSC_ID','ASC')
                            ->paginate(30);
        }else{  
            $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                            'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                            'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                            'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                            'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                            'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',                 
                            'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                            'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                            'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                            'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                            'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                            'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                            'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                            ->where('OSC_ID',$arbol_id)
                            ->paginate(30);            
        }
        //dd($regcontable);
        if($regcontable->count() <= 0){
            toastr()->error('No existen requisitos contables.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }
        return view('sicinar.requisitos.verReqc',compact('nombre','usuario','regosc','regperiodicidad','regnumeros', 'regperiodos','regcontable','regformatos'));
    }


    public function actionNuevoReqc(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID', 'NUM_DESC')->orderBy('NUM_ID','asc')
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->orderBy('PER_ID','asc')
                        ->get();   
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        if(session()->get('rango') !== '0'){        
            $regosc   = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->orderBy('OSC_DESC','asc')
                        ->get();
        }else{
            $regosc   = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')
                        ->where('OSC_ID',$arbol_id)
                        ->get();            
        }                        
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                        'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                        'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                        'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                        'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',                        
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('OSC_ID','ASC')
                        ->get();        
        //dd($unidades);
        return view('sicinar.requisitos.nuevoReqc',compact('regper','regnumeros','regosc','regperiodos','regperiodicidad','nombre','usuario','regcontable','regformatos'));
    }

    public function actionAltaNuevoReqc(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        /************ Obtenemos la IP ***************************/                
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }        

        /************ Registro *****************************/ 
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                        'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                        'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                        'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                        'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',             
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $request->periodo_id,'OSC_ID' => $request->osc_id])
                        ->get();
        if($regcontable->count() <= 0 && !empty($request->osc_id)){
            //********** Registrar la alta *****************************/
            $osc_folio = regReqContablesModel::max('OSC_FOLIO');
            $osc_folio = $osc_folio+1;
            $nuevocontable = new regReqContablesModel();

            $file1 =null;
            if(isset($request->osc_d1)){
                if(!empty($request->osc_d1)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('osc_d1')){
                        $file1=$request->osc_id.'_'.$request->file('osc_d1')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('osc_d1')->move(public_path().'/images/', $file1);
                    }
                }
            }
            $file2 =null;
            if(isset($request->osc_d2)){
                if(!empty($request->osc_d2)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('osc_d2')){
                        $file2=$request->osc_id.'_'.$request->file('osc_d2')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('osc_d2')->move(public_path().'/images/', $file2);
                    }
                }
            }
            $file3 =null;
            if(isset($request->osc_d3)){
                if(!empty($request->osc_d3)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('osc_d3')){
                        $file3=$request->osc_id.'_'.$request->file('osc_d3')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('osc_d3')->move(public_path().'/images/', $file3);
                    }
                }
            }            
            $file6 =null;
            if(isset($request->osc_d6)){
                if(!empty($request->osc_d6)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('osc_d6')){
                        $file6=$request->osc_id.'_'.$request->file('osc_d6')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('osc_d6')->move(public_path().'/images/', $file6);
                    }
                }
            }            

            $file10 =null;
            if(isset($request->osc_d10)){
                if(!empty($request->osc_d10)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('osc_d10')){
                        $file10=$request->osc_id.'_'.$request->file('osc_d10')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('osc_d10')->move(public_path().'/images/', $file10);
                    }
                }
            }
            $file11 =null;
            if(isset($request->osc_d11)){
                if(!empty($request->osc_d11)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('osc_d11')){
                        $file11=$request->osc_id.'_'.$request->file('osc_d11')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('osc_d11')->move(public_path().'/images/', $file11);
                    }
                }
            }

            $nuevocontable->OSC_FOLIO    = $osc_folio;
            $nuevocontable->PERIODO_ID   = $request->periodo_id;
            $nuevocontable->OSC_ID       = $request->osc_id;        

            $nuevocontable->DOC_ID1      = $request->doc_id1;
            $nuevocontable->FORMATO_ID1  = $request->formato_id1;
            $nuevocontable->OSC_D1       = $file1;        
            $nuevocontable->NUM_ID1      = $request->num_id1;
            $nuevocontable->PER_ID1      = $request->per_id1;        
            $nuevocontable->OSC_EDO1     = $request->osc_edo1;

            $nuevocontable->DOC_ID2      = $request->doc_id2;
            $nuevocontable->FORMATO_ID2  = $request->formato_id2;
            $nuevocontable->OSC_D2       = $file2;        
            $nuevocontable->NUM_ID2      = $request->num_id2;
            $nuevocontable->PER_ID2      = $request->per_id2;        
            $nuevocontable->OSC_EDO2     = $request->osc_edo2;

            $nuevocontable->DOC_ID3      = $request->doc_id3;
            $nuevocontable->FORMATO_ID3  = $request->formato_id3;
            $nuevocontable->OSC_D3       = $file3;        
            $nuevocontable->NUM_ID3      = $request->num_id3;
            $nuevocontable->PER_ID3      = $request->per_id3;        
            $nuevocontable->OSC_EDO3     = $request->osc_edo3;

            $nuevocontable->DOC_ID9      = $request->doc_id9;
            $nuevocontable->FORMATO_ID9  = $request->formato_id9;
            $nuevocontable->OSC_D9       = $file9;        
            $nuevocontable->NUM_ID9      = $request->num_id9;
            $nuevocontable->PER_ID9      = $request->per_id9;        
            $nuevocontable->OSC_EDO9     = $request->osc_edo9;        

            $nuevocontable->DOC_ID10     = $request->doc_id10;
            $nuevocontable->FORMATO_ID10 = $request->formato_id10;
            $nuevocontable->OSC_D10      = $file10;        
            $nuevocontable->NUM_ID10     = $request->num_id10;
            $nuevocontable->PER_ID10     = $request->per_id10;        
            $nuevocontable->OSC_EDO10    = $request->osc_edo10; 

            $nuevocontable->DOC_ID11     = $request->doc_id11;
            $nuevocontable->FORMATO_ID11 = $request->formato_id11;
            $nuevocontable->OSC_D11      = $file11;        
            $nuevocontable->NUM_ID11     = $request->num_id11;
            $nuevocontable->PER_ID11     = $request->per_id11;        
            $nuevocontable->OSC_EDO11    = $request->osc_edo11;         

            $nuevocontable->IP           = $ip;
            $nuevocontable->LOGIN        = $nombre;         // Usuario ;
            $nuevocontable->save();

            if($nuevocontable->save() == true){
                toastr()->success('Información contable registrada.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3004;
                $xtrx_id      =        94;    //alta
                $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                           'FUNCION_ID','TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN',
                                           'FECHA_M', 'IP_M', 'LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $request->osc_id])
                               ->get();
                if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $request->osc_id;      // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                       toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                       toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                          'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                          'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                                          'FOLIO' => $request->osc_id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************               
                    $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                            'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                            'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,
                                            'FOLIO' => $request->osc_id])
                                   ->update([
                                             'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                             'IP_M'     => $regbitacora->IP       = $ip,
                                             'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                             'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                            ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
                
                //return redirect()->route('nuevocontable');
                //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','rango','preguntas','apartados'));
            }else{
                toastr()->error('Error inesperado al registrar requisitos contables. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                //return back();
                //return redirect()->route('nuevocontable');
            }   //******************** Termina la alta ************************/ 

        }else{
            toastr()->error('Ya existen requisitos contables.','Por favor editar, lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }   // Termian If de busqueda ****************

        return redirect()->route('verReqc');
    }


    /****************** Editar registro  **********/
    public function actionEditarReqc($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID', 'NUM_DESC')->orderBy('NUM_ID','asc')
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->orderBy('PER_ID','asc')
                        ->get();                                
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->orderBy('OSC_DESC','asc')
                        ->get();
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                        'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                        'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                        'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                        'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',             
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('OSC_FOLIO', $id)
                        ->first();
        if($regcontable->count() <= 0){
            toastr()->error('No existe requisitos contables.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }
        return view('sicinar.requisitos.editarReqc',compact('nombre','usuario','regosc','regcontable','regnumeros', 'regperiodos','regperiodicidad','regformatos'));
    }
    
    public function actionActualizarReqc(reqcontablesRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');        

        // **************** actualizar ******************************
        $regcontable = regReqContablesModel::where('OSC_FOLIO',$id);
        if($regcontable->count() <= 0)
            toastr()->error('No existen otros requisitos contables.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //****************** Actualizar **************************/
            //echo "Escribió en el campo de texto 1: " .'-'. $request->osc_d9 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->osc_d9 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            $name1 =null;        
            if($request->hasFile('osc_d1')){
                $name1 = $id.'_'.$request->file('osc_d1')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d1')->move(public_path().'/images/', $name1);
            }            
            $name2 =null;        
            if($request->hasFile('osc_d2')){
                $name2 = $id.'_'.$request->file('osc_d2')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d2')->move(public_path().'/images/', $name2);
            }            
            $name3 =null;        
            if($request->hasFile('osc_d3')){
                echo "Escribió en el campo de texto 3: " .'-'. $request->osc_d3 .'-'. "<br><br>"; 
                $name3 = $id.'_'.$request->file('osc_d3')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d3')->move(public_path().'/images/', $name3);
            }
            $name6 =null;        
            if($request->hasFile('osc_d6')){
                $name6 = $id.'_'.$request->file('osc_d6')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d6')->move(public_path().'/images/', $name6);
            }            

            $name10 =null;        
            if($request->hasFile('osc_d10')){
                echo "Escribió en el campo de texto 10: " .'-'. $request->osc_d10 .'-'. "<br><br>"; 
                $name10 = $id.'_'.$request->file('osc_d10')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d10')->move(public_path().'/images/', $name10);
            }            
            $name11 =null;        
            if($request->hasFile('osc_d11')){
                echo "Escribió en el campo de texto 11: " .'-'. $request->osc_d11 .'-'. "<br><br>"; 
                $name11 = $id.'_'.$request->file('osc_d11')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d11')->move(public_path().'/images/', $name11);
            }            

            // ************* Actualizamos registro **********************************
            $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([                
                                     //'PERIODO_ID' => $request->periodo_id,

                                     'DOC_ID1'      => $request->doc_id1,
                                     'FORMATO_ID1'  => $request->formato_id1,                            
                                     //'OSC_D1'     => $name1,                                                       
                                     'PER_ID1'      => $request->per_id1,
                                     'NUM_ID1'      => $request->num_id1,                
                                     'OSC_EDO1'     => $request->osc_edo1,

                                     'DOC_ID2'      => $request->doc_id2,
                                     'FORMATO_ID2'  => $request->formato_id2,                            
                                     //'OSC_D2'     => $name2,                                                       
                                     'PER_ID2'      => $request->per_id2,
                                     'NUM_ID2'      => $request->num_id2,                
                                     'OSC_EDO2'     => $request->osc_edo2,

                                     'DOC_ID3'      => $request->doc_id3,
                                     'FORMATO_ID3'  => $request->formato_id3, 
                                     //'OSC_D3'     => $name3,                                                       
                                     'PER_ID3'      => $request->per_id3,
                                     'NUM_ID3'      => $request->num_id3,                
                                     'OSC_EDO3'     => $request->osc_edo3,

                                     'DOC_ID9'      => $request->doc_id9,
                                     'FORMATO_ID9'  => $request->formato_id9,                            
                                     //'OSC_D9'     => $name9,                                                       
                                     'PER_ID9'      => $request->per_id9,
                                     'NUM_ID9'      => $request->num_id9,                
                                     'OSC_EDO9'     => $request->osc_edo9,
                                    
                                     'DOC_ID10'     => $request->doc_id10,
                                     'FORMATO_ID10' => $request->formato_id10,                                          
                                     //'OSC_D10'    => name10,              
                                     'PER_ID10'     => $request->per_id10,
                                     'NUM_ID10'     => $request->num_id10,                
                                     'OSC_EDO10'    => $request->osc_edo10,
                                     
                                     'DOC_ID11'     => $request->doc_id11,
                                     'FORMATO_ID11' => $request->formato_id11, 
                                     //'OSC_D11'    => $name11,        
                                     'PER_ID11'     => $request->per_id11,
                                     'NUM_ID11'     => $request->num_id11,                
                                     'OSC_EDO11'    => $request->osc_edo11,

                                     //'OSC_STATUS' => $request->osc_status,
                                     'IP_M'         => $ip,
                                     'LOGIN_M'      => $nombre,
                                     'FECHA_M'      => date('Y/m/d')    //date('d/m/
                                    ]);
            toastr()->success('Otros requisitos contables actualizados.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3004;
            $xtrx_id      =        95;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M',
                                                    'IP_M','LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************                    
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO' => $id])
                               ->update([
                                          'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                          'IP_M'    => $regbitacora->IP       = $ip,
                                          'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                          'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/         
        }       /************ Termina actualizar ***********************************/
        return redirect()->route('verReqc');
        
    }


    /****************** Editar requisitos contables **********/
    public function actionEditarReqc1($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        //dd($id,$id2);
        $regnumeros   = regNumerosModel::select('NUM_ID', 'NUM_DESC')->orderBy('NUM_ID','asc')
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->orderBy('PER_ID','asc')
                        ->get(); 
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();                               
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->orderBy('OSC_DESC','asc')
                        ->get();
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                        'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                        'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                        'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                        'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',              
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('OSC_FOLIO', $id)
                        ->first();
        if($regcontable->count() <= 0){
            toastr()->error('No existe requisitos contables.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }
        return view('sicinar.requisitos.editarReqc1',compact('nombre','usuario','regosc','regcontable','regnumeros', 'regperiodos','regperiodicidad','regformatos'));
    }

    public function actionActualizarReqc1(reqcontablesRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');        
        
        // **************** actualizar ******************************
        $regcontable = regReqContablesModel::where('OSC_FOLIO',$id);
        if($regcontable->count() <= 0)
            toastr()->error('No existe archivo PDF 1.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        

            //echo "Escribió en el campo de texto 1: " .'-'. $request->osc_d9 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->osc_d9 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            $name1 =null;
            if($request->hasFile('osc_d1')){
                echo "Escribió en el campo de texto 1: " .'-'. $request->osc_d1 .'-'. "<br><br>"; 
                $name1 = $id.'_'.$request->file('osc_d1')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d1')->move(public_path().'/images/', $name1);

                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID1'    => $request->doc_id1,
                                     'FORMATO_ID1'=> $request->formato_id1,             
                                     'OSC_D1'     => $name1,                  
                                     'PER_ID1'    => $request->per_id1,
                                     'NUM_ID1'    => $request->num_id1,                
                                     'OSC_EDO1'   => $request->osc_edo1,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                toastr()->success('archivo contable 1 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }else{
                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID1'    => $request->doc_id1,
                                     'FORMATO_ID1'=> $request->formato_id1,             
                                     //'OSC_D1'   => $name1,                  
                                     'PER_ID1'    => $request->per_id1,
                                     'NUM_ID1'    => $request->num_id1,                
                                     'OSC_EDO1'   => $request->osc_edo1,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);                
                toastr()->success('archivo contable 1 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3004;
            $xtrx_id      =        95;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                               'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $id;             // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************                    
                    $regbitacora= regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                  ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                           'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 
                                           'FOLIO' => $id])
                                  ->update([
                                            'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                            'IP_M' => $regbitacora->IP           = $ip,
                                            'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                            'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                          ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/         
            
        }       /************ Termina de actualizar ********************************/

        return redirect()->route('verReqc');
        
    }    

    /****************** Editar requisitos contables **********/
    public function actionEditarReqc2($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id     = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID', 'NUM_DESC')->orderBy('NUM_ID','asc')
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->orderBy('PER_ID','asc')
                        ->get(); 
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();                               
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->orderBy('OSC_DESC','asc')
                        ->get();
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('OSC_FOLIO', $id)
                        ->first();
        if($regcontable->count() <= 0){
            toastr()->error('No existe requisito contable.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }
        return view('sicinar.requisitos.editarReqc2',compact('nombre','usuario','regosc','regcontable','regnumeros', 'regperiodos','regperiodicidad','regformatos'));
    }

    public function actionActualizarReqc2(reqcontablesRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');        

        // **************** actualizar ******************************
        $regcontable = regReqContablesModel::where('OSC_FOLIO',$id);
        if($regcontable->count() <= 0)
            toastr()->error('No existe archivo PDF 2.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        

            //echo "Escribió en el campo de texto 1: " .'-'. $request->osc_d9 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->osc_d9 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            $name2 =null;
            if($request->hasFile('osc_d2')){
                echo "Escribió en el campo de texto 2: " .'-'. $request->osc_d2 .'-'. "<br><br>"; 
                $name2 = $id.'_'.$request->file('osc_d2')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d2')->move(public_path().'/images/', $name2);

                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID2'    => $request->doc_id2,
                                     'FORMATO_ID2'=> $request->formato_id2,             
                                     'OSC_D2'     => $name2,                  
                                     'PER_ID2'    => $request->per_id2,
                                     'NUM_ID2'    => $request->num_id2,                
                                     'OSC_EDO2'   => $request->osc_edo2,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                toastr()->success('archivo contable 2 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }else{
                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID2'    => $request->doc_id2,
                                     'FORMATO_ID2'=> $request->formato_id2,             
                                     //'OSC_D2'   => $name2,                  
                                     'PER_ID2'    => $request->per_id2,
                                     'NUM_ID2'    => $request->num_id2,                
                                     'OSC_EDO2'   => $request->osc_edo2,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);                
                toastr()->success('archivo contable 2 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3004;
            $xtrx_id      =        95;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                               'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $id;             // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************                    
                    $regbitacora= regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                  ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                           'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 
                                           'FOLIO' => $id])
                                  ->update([
                                            'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                            'IP_M' => $regbitacora->IP           = $ip,
                                            'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                            'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                          ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/         
            
        }       /************ Termina de actualizar ********************************/

        return redirect()->route('verReqc');
        
    }    

    /****************** Editar requisitos contables **********/
    public function actionEditarReqc3($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID', 'NUM_DESC')->orderBy('NUM_ID','asc')
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->orderBy('PER_ID','asc')
                        ->get(); 
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();                               
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->orderBy('OSC_DESC','asc')
                        ->get();
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                        'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                        'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                        'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                        'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',              
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',    
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('OSC_FOLIO', $id)
                        ->first();
        if($regcontable->count() <= 0){
            toastr()->error('No existe requisitos contables.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }
        return view('sicinar.requisitos.editarReqc3',compact('nombre','usuario','regosc','regcontable','regnumeros', 'regperiodos','regperiodicidad','regformatos'));
    }

    public function actionActualizarReqc3(reqcontablesRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');        

        // **************** actualizar ******************************
        $regcontable = regReqContablesModel::where('OSC_FOLIO',$id);
        if($regcontable->count() <= 0)
            toastr()->error('No existe archivo PDF 3.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        

            //echo "Escribió en el campo de texto 1: " .'-'. $request->osc_d9 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->osc_d9 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            $name3 =null;
            if($request->hasFile('osc_d3')){
                echo "Escribió en el campo de texto 3: " .'-'. $request->osc_d3 .'-'. "<br><br>"; 
                $name3 = $id.'_'.$request->file('osc_d3')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d3')->move(public_path().'/images/', $name3);

                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID3'    => $request->doc_id3,
                                     'FORMATO_ID3'=> $request->formato_id3,             
                                     'OSC_D3'     => $name3,                  
                                     'PER_ID3'    => $request->per_id3,
                                     'NUM_ID3'    => $request->num_id3,                
                                     'OSC_EDO3'   => $request->osc_edo3,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                toastr()->success('archivo contable 3 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }else{
                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID3'    => $request->doc_id3,
                                     'FORMATO_ID3'=> $request->formato_id3,             
                                     //'OSC_D3'   => $name3,                  
                                     'PER_ID3'    => $request->per_id3,
                                     'NUM_ID3'    => $request->num_id3,                
                                     'OSC_EDO3'   => $request->osc_edo3,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);                
                toastr()->success('archivo contable 3 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3004;
            $xtrx_id      =        95;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                               'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $id;             // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************                    
                    $regbitacora= regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                  ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                           'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 
                                           'FOLIO' => $id])
                                  ->update([
                                            'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                            'IP_M' => $regbitacora->IP           = $ip,
                                            'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                            'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                          ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/         
            
        }       /************ Termina de actualizar ********************************/
        return redirect()->route('verReqc');    
    }    


    /****************** Editar requisitos contables **********/
    public function actionEditarReqc6($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID', 'NUM_DESC')->orderBy('NUM_ID','asc')
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                        ->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->orderBy('PER_ID','asc')
                        ->get(); 
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();                               
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')->orderBy('OSC_DESC','asc')
                        ->get();
        $regcontable  = regReqContablesModel::select('OSC_ID','PERIODO_ID', 'OSC_FOLIO',
                        'DOC_ID1' ,'FORMATO_ID1' ,'OSC_D1' ,'PER_ID1' ,'NUM_ID1' ,'OSC_EDO1',
                        'DOC_ID2' ,'FORMATO_ID2' ,'OSC_D2' ,'PER_ID2' ,'NUM_ID2' ,'OSC_EDO2',
                        'DOC_ID3' ,'FORMATO_ID3' ,'OSC_D3' ,'PER_ID3' ,'NUM_ID3' ,'OSC_EDO3',            
                        'DOC_ID4' ,'FORMATO_ID4' ,'OSC_D4' ,'PER_ID4' ,'NUM_ID4' ,'OSC_EDO4',
                        'DOC_ID5' ,'FORMATO_ID5' ,'OSC_D5' ,'PER_ID5' ,'NUM_ID5' ,'OSC_EDO5',              
                        'DOC_ID6' ,'FORMATO_ID6' ,'OSC_D6' ,'PER_ID6' ,'NUM_ID6' ,'OSC_EDO6',
                        'DOC_ID7' ,'FORMATO_ID7' ,'OSC_D7' ,'PER_ID7' ,'NUM_ID7' ,'OSC_EDO7',
                        'DOC_ID8' ,'FORMATO_ID8' ,'OSC_D8' ,'PER_ID8' ,'NUM_ID8' ,'OSC_EDO8',
                        'DOC_ID9' ,'FORMATO_ID9' ,'OSC_D9' ,'PER_ID9' ,'NUM_ID9' ,'OSC_EDO9',                        
                        'DOC_ID10','FORMATO_ID10','OSC_D10','PER_ID10','NUM_ID10','OSC_EDO10',                        
                        'DOC_ID11','FORMATO_ID11','OSC_D11','PER_ID11','NUM_ID11','OSC_EDO11',      
                        'OSC_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('OSC_FOLIO', $id)
                        ->first();
        if($regcontable->count() <= 0){
            toastr()->error('No existe requisitos contables.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevocontable');
        }
        return view('sicinar.requisitos.editarReqc6',compact('nombre','usuario','regosc','regcontable','regnumeros', 'regperiodos','regperiodicidad','regformatos'));
    }

    public function actionActualizarReqc6(reqcontablesRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');        

        // **************** actualizar ******************************
        $regcontable = regReqContablesModel::where('OSC_FOLIO',$id);
        if($regcontable->count() <= 0)
            toastr()->error('No existe archivo PDF6.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        

            //echo "Escribió en el campo de texto 1: " .'-'. $request->osc_d9 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->osc_d9 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            $name6 =null;
            if($request->hasFile('osc_d6')){
                echo "Escribió en el campo de texto 6: " .'-'. $request->osc_d6 .'-'. "<br><br>"; 
                $name6 = $id.'_'.$request->file('osc_d6')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('osc_d6')->move(public_path().'/images/', $name6);

                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID6'    => $request->doc_id6,
                                     'FORMATO_ID6'=> $request->formato_id6,             
                                     'OSC_D6'     => $name6,                  
                                     'PER_ID6'    => $request->per_id6,
                                     'NUM_ID6'    => $request->num_id6,                
                                     'OSC_EDO6'   => $request->osc_edo6,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                toastr()->success('archivo contable 6 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }else{
                // ************* Actualizamos registro **********************************
                $regcontable = regReqContablesModel::where('OSC_FOLIO',$id)        
                           ->update([   
                                     'DOC_ID6'    => $request->doc_id6,
                                     'FORMATO_ID6'=> $request->formato_id6,             
                                     //'OSC_D6'   => $name6,                  
                                     'PER_ID6'    => $request->per_id6,
                                     'NUM_ID6'    => $request->num_id6,                
                                     'OSC_EDO6'   => $request->osc_edo6,

                                     'IP_M'        => $ip,
                                     'LOGIN_M'     => $nombre,
                                     'FECHA_M'     => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);                
                toastr()->success('archivo contable 6 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3004;
            $xtrx_id      =        95;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                               'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $id;             // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************                    
                    $regbitacora= regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                  ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                           'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 
                                           'FOLIO' => $id])
                                  ->update([
                                            'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                            'IP_M'    => $regbitacora->IP       = $ip,
                                            'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                            'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                          ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/         
        }       /************ Termina de actualizar ********************************/
        return redirect()->route('verReqc');
    }    


    //***** Borrar registro completo ***********************
    public function actionBorrarReqc($id){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        /************ Elimina transacción de asistencia social y contable ***************/
        $regcontable = regReqContablesModel::where('OSC_FOLIO',$id);
        if($regcontable->count() <= 0)
            toastr()->error('No existe requisito contable.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regcontable->delete();
            toastr()->success('Requisito contable eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre aboorar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3004;
            $xtrx_id      =        96;     // borrar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                           'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                             'MES_ID'  => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/    
        }   /************* Termina de eliminar  ************************************/
        return redirect()->route('verReqc');
    }    

}