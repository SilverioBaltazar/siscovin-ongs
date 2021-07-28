<?php
//***********************************************************************************************************/
//* File:       balanzaController.php
//* Proyecto:   Sistema SIINAP.V2 JAPEM
//¨Función:     Clases para el modulo de requísitos contables, estados financieros y balanza de comprobación
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: enero 2020
//* @Derechos reservados. Gobierno del Estado de México
//************************************************************************************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\balanzaRequest;
use App\Http\Requests\balanza1Request;
use App\regIapModel;
use App\regBitacoraModel;
use App\regPfiscalesModel;
use App\regPerModel;
use App\regNumerosModel;
use App\regFormatosModel;
use App\regMesesModel;
use App\regDiasModel;
use App\regBalanzaModel;

// Exportar a excel 
use Maatwebsite\Excel\Facades\Excel;

// Exportar a pdf
use PDF;
//use Options;

class balanzaController extends Controller
{

    //******** Mostrar edos financieros *****//
    public function actionverBalanza(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regperiodicidad= regPerModel::select('PER_ID','PER_DESC')->where('PER_ID', 4)
                        ->get();                          
        $regnumeros   = regNumerosModel::select('NUM_ID','NUM_DESC')->wherein('NUM_ID',[1,2])
                        ->get();
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID','PERIODO_DESC')->get(); 
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();             
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){          
            $regbalanza=regBalanzaModel::select('EDOFINAN_FOLIO','PERIODO_ID','DOC_ID','FORMATO_ID',
                        'PER_ID','NUM_ID','IAP_ID',
                        'IDS_DREEF','IDS_DREES','IDS_CRECUP','IDS_AGUB','IDS_LDING',
                        'EDS_CA','EDS_GA','EDS_CF','REMAN_SEM','ACT_CIRC','ACT_NOCIRC','ACT_NOCIRCINM',
                        'PAS_ACP','PAS_ALP','PATRIMONIO',
                        'EDOFINAN_FECHA','EDOFINAN_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'EDOFINAN_FOTO1','EDOFINAN_FOTO2','EDOFINAN_OBS','EDOFINAN_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('IAP_ID','ASC')
                        ->paginate(30);
        }else{
            $regbalanza=regBalanzaModel::select('EDOFINAN_FOLIO','PERIODO_ID','DOC_ID','FORMATO_ID',
                        'PER_ID','NUM_ID','IAP_ID',
                        'IDS_DREEF','IDS_DREES','IDS_CRECUP','IDS_AGUB','IDS_LDING',
                        'EDS_CA','EDS_GA','EDS_CF','REMAN_SEM','ACT_CIRC','ACT_NOCIRC','ACT_NOCIRCINM',
                        'PAS_ACP','PAS_ALP','PATRIMONIO',
                        'EDOFINAN_FECHA','EDOFINAN_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'EDOFINAN_FOTO1','EDOFINAN_FOTO2','EDOFINAN_OBS','EDOFINAN_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('IAP_ID',$arbol_id)
                        ->paginate(30);            
        }
        if($regbalanza->count() <= 0){
            toastr()->error('No existen Requisito contable-Edo. financiero y Balanza de comprobación.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoasistencial');
        }
        return view('sicinar.edosfinancieros.verBalanza',compact('nombre','usuario','regiap','regperiodicidad','regnumeros', 'regperiodos','regmeses','regdias','regformatos','regbalanza'));
    }


    public function actionNuevaBalanza(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID','NUM_DESC')->wherein('NUM_ID',[1,2])
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->where('PER_ID', 4)->get();  
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();               
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        if(session()->get('rango') !== '0'){                                
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->orderBy('IAP_DESC','asc')
                        ->get();
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                        ->where('IAP_ID',$arbol_id)
                        ->get();            
        }                                                
        $regbalanza   = regBalanzaModel::select('EDOFINAN_FOLIO','PERIODO_ID','DOC_ID','FORMATO_ID',
                        'PER_ID','NUM_ID','IAP_ID',
                        'IDS_DREEF','IDS_DREES','IDS_CRECUP','IDS_AGUB','IDS_LDING',
                        'EDS_CA','EDS_GA','EDS_CF','REMAN_SEM','ACT_CIRC','ACT_NOCIRC','ACT_NOCIRCINM',
                        'PAS_ACP','PAS_ALP','PATRIMONIO',
                        'EDOFINAN_FECHA','EDOFINAN_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'EDOFINAN_FOTO1','EDOFINAN_FOTO2','EDOFINAN_OBS','EDOFINAN_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->get();        
        //dd($unidades);
        return view('sicinar.edosfinancieros.nuevaBalanza',compact('nombre','usuario','regper','regnumeros','regiap','regperiodos','regmeses','regdias','regperiodicidad','regformatos','regbalanza'));
    }

    public function actionAltaNuevaBalanza(Request $request){
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
        $regbalanza   = regBalanzaModel::select('EDOFINAN_FOLIO','PERIODO_ID','DOC_ID','FORMATO_ID',
                        'PER_ID','NUM_ID','IAP_ID',
                        'IDS_DREEF','IDS_DREES','IDS_CRECUP','IDS_AGUB','IDS_LDING',
                        'EDS_CA','EDS_GA','EDS_CF','REMAN_SEM','ACT_CIRC','ACT_NOCIRC','ACT_NOCIRCINM',
                        'PAS_ACP','PAS_ALP','PATRIMONIO',
                        'EDOFINAN_FECHA','EDOFINAN_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'EDOFINAN_FOTO1','EDOFINAN_FOTO2','EDOFINAN_OBS','EDOFINAN_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $request->periodo_id,'NUM_ID' => $request->num_id,'IAP_ID' => $request->iap_id])
                        ->get();
        if($regbalanza->count() <= 0 && !empty($request->iap_id)){
            //********** Registrar la alta *****************************/
            $mes1 = regMesesModel::ObtMes($request->mes_id1);
            $dia1 = regDiasModel::ObtDia($request->dia_id1);                

            $edofinan_folio = regBalanzaModel::max('EDOFINAN_FOLIO');
            $edofinan_folio = $edofinan_folio+1;

            $nuevabalanza   = new regBalanzaModel();

            $file1 =null;
            if(isset($request->edofinan_foto1)){
                if(!empty($request->edofinan_foto1)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('edofinan_foto1')){
                        $file1=$request->iap_id.'_'.$request->file('edofinan_foto1')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('edofinan_foto1')->move(public_path().'/images/', $file1);
                    }
                }
            }            
            $nuevabalanza->EDOFINAN_FOLIO = $edofinan_folio;        
            $nuevabalanza->PERIODO_ID     = $request->periodo_id;
            $nuevabalanza->IAP_ID         = $request->iap_id;        

            $nuevabalanza->DOC_ID         = 12;
            $nuevabalanza->FORMATO_ID     = $request->formato_id;
            $nuevabalanza->NUM_ID         = $request->num_id;
            $nuevabalanza->PER_ID         = $request->per_id;        

            $nuevabalanza->IDS_DREEF      = $request->ids_dreef;
            $nuevabalanza->IDS_DREES      = $request->ids_drees;
            $nuevabalanza->IDS_CRECUP     = $request->ids_crecup;        
            $nuevabalanza->IDS_AGUB       = $request->ids_agub;
            $nuevabalanza->IDS_LDING      = $request->ids_lding;        

            $nuevabalanza->EDS_CA         = $request->eds_ca; 
            $nuevabalanza->EDS_GA         = $request->eds_ga;
            $nuevabalanza->EDS_CF         = $request->eds_cf; 
            $nuevabalanza->REMAN_SEM      = $request->reman_sem;
            $nuevabalanza->ACT_CIRC       = $request->act_circ; 
            $nuevabalanza->ACT_NOCIRC     = $request->act_nocirc;
            $nuevabalanza->ACT_NOCIRCINM  = $request->act_nocircinm;

            $nuevabalanza->PAS_ACP        = $request->pas_acp; 
            $nuevabalanza->PAS_ALP        = $request->pas_alp;
            $nuevabalanza->PATRIMONIO     = $request->patrimonio;

            $nuevabalanza->EDOFINAN_FECHA = date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) ));
            $nuevabalanza->EDOFINAN_FECHA2= trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1);
            $nuevabalanza->PERIODO_ID1    = $request->periodo_id1;
            $nuevabalanza->MES_ID1        = $request->mes_id1;        
            $nuevabalanza->DIA_ID1        = $request->dia_id1; 

            $nuevabalanza->EDOFINAN_OBS   = substr(trim(strtoupper($request->edofinan_obs)),0,4999);
            $nuevabalanza->EDOFINAN_FOTO1 = $file1;        

            $nuevabalanza->IP             = $ip;
            $nuevabalanza->LOGIN          = $nombre;         // Usuario ;
            $nuevabalanza->save();

            if($nuevabalanza->save() == true){
                toastr()->success('Edo. financiero y balanza de comprobación registrada.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3010;
                $xtrx_id      =        22;    //alta
                $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                           'FUNCION_ID','TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN',
                                           'FECHA_M', 'IP_M', 'LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $edofinan_folio])
                               ->get();
                if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $edofinan_folio;      // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                       toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                       toastr()->error('Error al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                          'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                          'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                                          'FOLIO' => $edofinan_folio])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************               
                    $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                            'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                            'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,
                                            'FOLIO' => $edofinan_folio])
                                   ->update([
                                             'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                             'IP_M'     => $regbitacora->IP       = $ip,
                                             'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                             'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                            ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
                
                //return redirect()->route('nuevoasistencial');
                //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','rango','preguntas','apartados'));
            }else{
                toastr()->error('Error inesperado al registrar Requisito contable-Edo. financiero-balanza de comp.. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                //return back();
                //return redirect()->route('nuevoasistencial');
            }   //******************** Termina la alta **************************************/ 

        }else{
            toastr()->error('Ya existen Edo. financiero y Balanza de comprobación.','Por favor revisar, lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoasistencial');
        }   //************************* Termian If de busqueda ******************************/

        return redirect()->route('verBalanza');
    }


    /****************** Editar registro  **********/
    public function actionEditarBalanza($id){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $arbol_id     = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID','NUM_DESC')->wherein('NUM_ID',[1,2])
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->where('PER_ID', 4)->get();                                
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();              
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                            ->get();                                                        
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                        ->where('IAP_ID',$arbol_id)
                        ->get();            
        }                    
        $regbalanza   = regBalanzaModel::select('EDOFINAN_FOLIO','PERIODO_ID','DOC_ID','FORMATO_ID',
                        'PER_ID','NUM_ID','IAP_ID',
                        'IDS_DREEF','IDS_DREES','IDS_CRECUP','IDS_AGUB','IDS_LDING',
                        'EDS_CA','EDS_GA','EDS_CF','REMAN_SEM','ACT_CIRC','ACT_NOCIRC','ACT_NOCIRCINM',
                        'PAS_ACP','PAS_ALP','PATRIMONIO',
                        'EDOFINAN_FECHA','EDOFINAN_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'EDOFINAN_FOTO1','EDOFINAN_FOTO2','EDOFINAN_OBS','EDOFINAN_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('EDOFINAN_FOLIO', $id)
                        ->first();
        if($regbalanza->count() <= 0){
            toastr()->error('No existe Requisito contable-Edo. financiero-balanza de comp..','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoasistencial');
        }
        return view('sicinar.edosfinancieros.editarBalanza',compact('nombre','usuario','regiap','regbalanza','regnumeros', 'regperiodos','regmeses','regdias','regperiodicidad','regformatos'));

    }
    
    public function actionActualizarBalanza(balanzaRequest $request, $id){
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
        $regbalanza = regBalanzaModel::where('EDOFINAN_FOLIO',$id);
        if($regbalanza->count() <= 0)
            toastr()->error('No existe Requisito contable-Edo. financiero-balanza de comp..','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //****************** Actualizar **************************/
            $mes1 = regMesesModel::ObtMes($request->mes_id1);
            $dia1 = regDiasModel::ObtDia($request->dia_id1);                

            $name1 =null;        
            if($request->hasFile('edofinan_foto1')){
                $name1 = $id.'_'.$request->file('edofinan_foto1')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('edofinan_foto1')->move(public_path().'/images/', $name1);
            }            
            // ************* Actualizamos registro **********************************
            $regbalanza= regBalanzaModel::where('EDOFINAN_FOLIO',$id)        
                         ->update([                
                                    //'PERIODO_ID'   => $request->periodo_id,
                            'FORMATO_ID'     => $request->formato_id,
                            'IDS_DREEF'      => $request->ids_dreef,
                            'IDS_DREES'      => $request->ids_drees,

                            'IDS_CRECUP'     => $request->ids_crecup,
                            'IDS_AGUB'       => $request->ids_agub,
                            'IDS_LDING'      => $request->ids_lding,
                            'EDS_CA'         => $request->eds_ca,
                            'EDS_GA'         => $request->eds_ga,                                     
                            'EDS_CF'         => $request->eds_cf,
                            'REMAN_SEM'      => $request->reman_sem,
                            'ACT_CIRC'       => $request->act_circ,
                            'ACT_NOCIRC'     => $request->act_nocirc,
                            'ACT_NOCIRCINM'  => $request->act_nocircinm, 
                            'PAS_ACP'        => $request->pas_acp,
                            'PAS_ALP'        => $request->pas_alp,
                            'PATRIMONIO'     => $request->patrimonio,

                            'EDOFINAN_FECHA' => date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) )),
                            'EDOFINAN_FECHA2'=> trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1), 
                            'PERIODO_ID1'    => $request->periodo_id1,
                            'MES_ID1'        => $request->mes_id1,
                            'DIA_ID1'        => $request->dia_id1,                                            

                            'EDOFINAN_OBS'   => substr(trim(strtoupper($request->edofinan_obs)),0,4999),        
                            'EDOFINAN_STATUS'=> $request->edofinan_status,                            

                            'IP_M'           => $ip,
                            'LOGIN_M'        => $nombre,
                            'FECHA_M'        => date('Y/m/d')    //date('d/m/
                                    ]);
            toastr()->success('Requisito contable-Edo. financiero-balanza de comp. actualizados.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3010;
            $xtrx_id      =        23;    //Actualizar         
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

        return redirect()->route('verBalanza');
        
    }

    /****************** Editar Requisito contable-Edo. financiero-balanza de comp. **********/
    public function actionEditarBalanza1($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id     = session()->get('arbol_id');        

        $regnumeros   = regNumerosModel::select('NUM_ID','NUM_DESC')->wherein('NUM_ID',[1,2])
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')->get();        
        $regperiodicidad= regPerModel::select('PER_ID', 'PER_DESC')->where('PER_ID', 4)->get(); 
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();              
        $regformatos  = regFormatosModel::select('FORMATO_ID','FORMATO_DESC')->get();                               
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();                                                        
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->where('IAP_ID',$arbol_id)
                        ->get();            
        }                    
        $regbalanza   = regBalanzaModel::select('EDOFINAN_FOLIO','PERIODO_ID','DOC_ID','FORMATO_ID',
                        'PER_ID','NUM_ID','IAP_ID',
                        'IDS_DREEF','IDS_DREES','IDS_CRECUP','IDS_AGUB','IDS_LDING',
                        'EDS_CA','EDS_GA','EDS_CF','REMAN_SEM','ACT_CIRC','ACT_NOCIRC','ACT_NOCIRCINM',
                        'PAS_ACP','PAS_ALP','PATRIMONIO',
                        'EDOFINAN_FECHA','EDOFINAN_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'EDOFINAN_FOTO1','EDOFINAN_FOTO2','EDOFINAN_OBS','EDOFINAN_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('EDOFINAN_FOLIO', $id)
                        ->first();
        if($regbalanza->count() <= 0){
            toastr()->error('No existe Requisito contable-Edo. financiero-balanza de comp..','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoasistencial');
        }
        return view('sicinar.edosfinancieros.editarBalanza1',compact('nombre','usuario','regiap','regbalanza','regnumeros', 'regperiodos','regmeses','regdias','regperiodicidad','regformatos'));
    }

    public function actionActualizarBalanza1(balanza1Request $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        // **************** actualizar ******************************
        $regbalanza = regBalanzaModel::where('EDOFINAN_FOLIO',$id);
        if($regbalanza->count() <= 0)
            toastr()->error('No existe archivo PDF.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        

            //echo "Escribió en el campo de texto 1: " .'-'. $request->iap_D4 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->iap_D4 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            $name1 =null;
            if($request->hasFile('edofinan_foto1')){
                echo "Escribió en el campo de texto d: " .'-'. $request->edofinan_foto1 .'-'. "<br><br>"; 
                $name1 = $id.'_'.$request->file('edofinan_foto1')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('edofinan_foto1')->move(public_path().'/images/', $name1);

                // ************* Actualizamos registro **********************************
                $regbalanza = regBalanzaModel::where('EDOFINAN_FOLIO',$id)        
                              ->update([   
                                     'EDOFINAN_FOTO1'=> $name1,                  

                                     'IP_M'          => $ip,
                                     'LOGIN_M'       => $nombre,
                                     'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                toastr()->success('Archivo digital PDF actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3010;
                $xtrx_id      =        23;    //Actualizar         
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
            }       /************ Valida archivo digital *******************************/
        }           /************ Termina de actualizar ********************************/

        return redirect()->route('verBalanza');
        
    }    


    //***** Borrar registro completo ***********************
    public function actionBorrarBalanza($id){
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

        /************ Elimina transacción  ***************/
        $regbalanza = regBalanzaModel::where('EDOFINAN_FOLIO',$id);
        if($regbalanza->count() <= 0)
            toastr()->error('No existe edo. financiero o balanza de comprobación.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regbalanza->delete();
            toastr()->success('Edo. financiero o balanza de comprobación eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre aboorar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3010;
            $xtrx_id      =        24;     // borrar 
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
        
        return redirect()->route('verBalanza');
    }    

}