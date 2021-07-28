<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\iapsRequest;
use App\Http\Requests\iaps5Request;
//use App\Http\Requests\iapsjuridicoRequest;
use App\regIapModel;
//use App\regIapJuridicoModel;
use App\regBitacoraModel;
use App\regMunicipioModel;
use App\regRubroModel;
use App\regEntidadesModel; 
use App\regVigenciaModel;
use App\regInmuebleedoModel;
use App\regPeriodosaniosModel;
use App\regMesesModel;
use App\regDiasModel;
use App\regFigjuridicaModel;

// Exportar a excel 
use App\Exports\ExcelExportCatIAPS;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class iapsController extends Controller
{

    public function actionBuscarIap(Request $request)
    {
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                        ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        $regmunicipio = regMunicipioModel::join('ONG_CAT_ENTIDADES_FED',
                                                'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                'ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',
                          'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID',
                          'ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[15])
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                        ->orderBy('RUBRO_ID','asc')
                        ->get(); 
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->orderBy('FIGJURIDICA_ID','asc')
                        ->get();                         
        $regvigencia  = regVigenciaModel::select('ANIO_ID', 'ANIO_DESC')->get();
        $reginmuebles = regInmuebleedoModel::select('INM_ID','INM_DESC')->get();   
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                
        $regtotactivas= regIapModel::selectRaw('COUNT(*) AS TOTAL_ACTIVAS')
                        ->where('IAP_STATUS','S')
                        ->get();
        $regtotinactivas=regIapModel::selectRaw('COUNT(*) AS TOTAL_INACTIVAS')
                        ->where('IAP_STATUS','N')
                        ->get();                                                                       
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $name  = $request->get('name');   
        $email = $request->get('email');  
        $bio   = $request->get('bio');    
        $regiap = regIapModel::orderBy('IAP_ID', 'ASC')
                  ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                  ->email($email)         //Metodos personalizados
                  ->bio($bio)             //Metodos personalizados
                  ->paginate(50);
        if($regiap->count() <= 0){
            toastr()->error('No existen registros de ONGS.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }            
        return view('sicinar.iaps.verIap', compact('nombre','usuario','regiap','regentidades','regmunicipio','regrubro','regvigencia','reginmuebles','regtotactivas','regtotinactivas','regperiodos','regmeses','regdias','regfigurajur'));
    }


    public function actionNuevaIap(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')                    
                        ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        $regmunicipio = regMunicipioModel::join('ONG_CAT_ENTIDADES_FED','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[15])
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                        ->orderBy('RUBRO_ID','asc')
                        ->get();  
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->orderBy('FIGJURIDICA_ID','asc')
                        ->get();                                        
        $regvigencia  = regVigenciaModel::select('ANIO_ID', 'ANIO_DESC')->get();
        $reginmuebles = regInmuebleedoModel::select('INM_ID','INM_DESC')->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();     
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC', 'IAP_DOM1','IAP_DOM2','IAP_DOM3','MUNICIPIO_ID', 
            'ENTIDADFEDERATIVA_ID','RUBRO_ID','FIGJURIDICA_ID','IAP_REGCONS','IAP_RFC','IAP_CP',
            'IAP_FECCONS','ONG_FECCONS2','ONG_FECCONS3',
            'IAP_TELEFONO','IAP_EMAIL','IAP_SWEB','IAP_PRES','IAP_REPLEGAL','IAP_SRIO','IAP_TESORERO','IAP_OBJSOC', 
            'IAP_STATUS', 'IAP_FECCERTIFIC','ONG_FECCERTIFIC2','ONG_FECCERTIFIC3','ANIO_ID','IAP_FVP','IAP_FVP2','INM_ID','IAP_FOTO1','IAP_FOTO2',
            'PERIODO_ID1','MES_ID1','DIA_ID1','PERIODO_ID2','MES_ID2','DIA_ID2',
            'IAP_OBS1','IAP_OBS2','IAP_GEOREF_LATITUD','IAP_GEOREF_LONGITUD','IP',
            'LOGIN','FECHA_M','IP_M','LOGIN_M')
                         ->orderBy('IAP_ID','asc')->get();
        //dd($unidades);
        return view('sicinar.iaps.nuevaIap',compact('regrubro','regmunicipio','regentidades','regiap','nombre','usuario','regvigencia','reginmuebles','regperiodos','regmeses','regdias','regfigurajur'));
    }

    public function actionAltaNuevaIap(Request $request){
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

        /************ ALTA  *****************************/ 
        //dd('periodo_d11=',$request->periodo1,'-mes_d1=',$request->mes1,'-dia_d1=',$request->dia1,'--periodo_d2=',$request->periodo_d2,'-mes_d2=',$request->mes_d2,'-dia_d2=',$request->dia_d2,'-iap_feccons=',$request->iap_feccons);
        //if(!empty($request->periodo_d1) and !empty($request->mes_d1) and !empty($request->dia_d1) ){
        //    toastr()->error('muy bien 1....................','¡ok...........!',['positionClass' => 'toast-bottom-right']);
        //    $mes1 = regMesesModel::ObtMes($request->mes_id1);
        //    $dia1 = regDiasModel::ObtDia($request->dia_id1);                
            ////xiap_feccons = $dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1;
        //}   ////endif
        
        //if(!empty($request->periodo_d2) and !empty($request->mes_d2) and !empty($request->dia_d2) ){
        //    toastr()->error('muy bien 2....................','¡ok...........!',['positionClass' => 'toast-bottom-right']);
        //    $mes2 = regMesesModel::ObtMes($request->mes_id2);
        //    $dia2 = regDiasModel::ObtDia($request->dia_id2);        
        //}

        //$mes1 = regMesesModel::ObtMes($request->mes_id1);
        //$dia1 = regDiasModel::ObtDia($request->dia_id1);                
        //$mes2 = regMesesModel::ObtMes($request->mes_id2);
        //$dia2 = regDiasModel::ObtDia($request->dia_id2);                

        $iap_id = regIapModel::max('IAP_ID');
        $iap_id = $iap_id+1;

        $nuevaiap = new regIapModel();
        $name1 =null;
        //Comprobar  si el campo foto1 tiene un archivo asignado:
        if($request->hasFile('iap_foto1')){
           $name1 = $iap_id.'_'.$request->file('iap_foto1')->getClientOriginalName(); 
           //$file->move(public_path().'/images/', $name1);
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('iap_foto1')->move(public_path().'/images/', $name1);
        }
        $name2 =null;
        //Comprobar  si el campo foto2 tiene un archivo asignado:        
        if($request->hasFile('iap_foto2')){
           $name2 = $iap_id.'_'.$request->file('iap_foto2')->getClientOriginalName(); 
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('iap_foto2')->move(public_path().'/images/', $name2);
        }

        $nuevaiap->IAP_ID      = $iap_id;
        $nuevaiap->IAP_DESC    = substr(trim(strtoupper($request->iap_desc)),0,159);
        $nuevaiap->IAP_DOM1    = substr(trim(strtoupper($request->iap_dom1)),0,149);
        $nuevaiap->IAP_DOM2    = substr(trim(strtoupper($request->iap_dom2)),0,149);
        $nuevaiap->IAP_DOM3    = substr(trim(strtoupper($request->iap_dom3)),0,149);
        //$nuevaiap->IAP_OTRAREF = strtoupper($request->iap_otraref);
        //$nuevaiap->IAP_COLONIA = strtoupper($request->iap_colonia);
        $nuevaiap->MUNICIPIO_ID= $request->municipio_id;
        $nuevaiap->ENTIDADFEDERATIVA_ID = $request->entidadfederativa_id;
        $nuevaiap->RUBRO_ID    = $request->rubro_id;
        $nuevaiap->FIGURAJURIDICA= $request->FIGJURIDICA_id;
        $nuevaiap->IAP_REGCONS = substr(trim(strtoupper($request->iap_regcons)),0,49);
        $nuevaiap->IAP_RFC     = substr(trim(strtoupper($request->iap_rfc)),0,17);
        $nuevaiap->IAP_CP      = $request->iap_cp;
        
        //$nuevaiap->IAP_FECCONS = date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) ));
        //$nuevaiap->IAP_FECCONS2= trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1);

        //$nuevoiap->PERIODO_ID1 = $request->periodo_id1;                
        //$nuevoiap->MES_ID1     = $request->mes_id1;                
        //$nuevoiap->DIA_ID1     = $request->dia_id1;       
        //$nuevaiap->IAP_FECCONS2= substr(trim($request->iap_feccons2),0,10);    
        $nuevaiap->IAP_FECCONS = $request->input('iap_feccons2');
        $nuevaiap->ONG_FECCONS2= $request->input('iap_feccons2');
        $nuevaiap->ONG_FECCONS3= $request->input('iap_feccons2');

        $nuevaiap->ANIO_ID     = $request->anio_id;        
        
        //$nuevaiap->IAP_FVP     = date('Y/m/d', strtotime(trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2) ));
        //$nuevaiap->IAP_FVP2    = trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2);        
        //$nuevoiap->PERIODO_ID2 = $request->periodo_id2;                
        //$nuevoiap->MES_ID2     = $request->mes_id2;                
        //$nuevoiap->DIA_ID2     = $request->dia_id2;  $request->input('iap_feccons2');            
        $nuevaiap->IAP_FVP2    = substr(trim($request->iap_fvp2),0,10);    

        $nuevaiap->INM_ID      = $request->inm_id;        
        $nuevaiap->IAP_TELEFONO= substr(trim(strtoupper($request->iap_telefono)),0,59);
        $nuevaiap->IAP_EMAIL   = substr(strtolower($request->iap_email),0,149);
        $nuevaiap->IAP_SWEB    = substr(trim(strtolower($request->iap_sweb)),0,99);
        $nuevaiap->IAP_PRES    = substr(trim(strtoupper($request->iap_pres)),0,79);
        $nuevaiap->IAP_REPLEGAL= substr(trim(strtoupper($request->iap_replegal)),0,149);
        $nuevaiap->IAP_SRIO    = substr(trim(strtoupper($request->iap_srio)),0,79);        
        $nuevaiap->IAP_TESORERO= substr(trim(strtoupper($request->iap_tesorero)),0,79);
        $nuevaiap->IAP_OBJSOC  = substr(trim(strtoupper($request->iap_objsoc)),0,799);
        $nuevaiap->IAP_OBS1    = substr(trim(strtoupper($request->iap_obs1)),0,199);
        $nuevaiap->IAP_GEOREF_LATITUD  = $request->iap_georef_latitud;
        $nuevaiap->IAP_GEOREF_LONGITUD = $request->iap_georef_longitud;
        
        $nuevaiap->IAP_FOTO1   = $name1;
        $nuevaiap->IAP_FOTO2   = $name2;
        $nuevaiap->IP          = $ip;
        $nuevaiap->LOGIN       = $nombre;         // Usuario ;
        //dd($nuevaiap);
        $nuevaiap->save();
        if($nuevaiap->save() == true){
            toastr()->success('ONG dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       145;    //Alta

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                    'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $iap_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $iap_id;         // Folio    
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
                                                      'FOLIO' => $iap_id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $iap_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/ 

            //return redirect()->route('nuevaIap');
            //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','estructura','id_estructura','rango','preguntas','apartados'));
        }else{
            toastr()->error('Error al dar de alta la ONG. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            //return back();
            //return redirect()->route('nuevoProceso');
        }

        return redirect()->route('verIap');
    }

    
    public function actionVerIap(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('ONG_CAT_ENTIDADES_FED','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                       'ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[15])
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                        ->orderBy('RUBRO_ID','asc')
                        ->get();      
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->orderBy('FIGJURIDICA_ID','asc')
                        ->get();                                        
        $regvigencia  = regVigenciaModel::select('ANIO_ID', 'ANIO_DESC')->get();
        $reginmuebles = regInmuebleedoModel::select('INM_ID','INM_DESC')->get();  
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                                                  
        $regtotactivas= regIapModel::selectRaw('COUNT(*) AS TOTAL_ACTIVAS')
                        ->where('IAP_STATUS','S')
                        ->get();
        $regtotinactivas=regIapModel::selectRaw('COUNT(*) AS TOTAL_INACTIVAS')
                        ->where('IAP_STATUS','N')
                        ->get();                        
        $regiap = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_DOM1','IAP_DOM2','IAP_DOM3','MUNICIPIO_ID',
                  'ENTIDADFEDERATIVA_ID','RUBRO_ID','FIGJURIDICA_ID','IAP_REGCONS','IAP_RFC','IAP_CP',
                  'IAP_FECCONS','ONG_FECCONS2','ONG_FECCONS3','IAP_TELEFONO',
                  'IAP_EMAIL','IAP_SWEB','IAP_PRES','IAP_REPLEGAL','IAP_SRIO','IAP_TESORERO','IAP_OBJSOC',
                  'ANIO_ID','IAP_FVP','IAP_FVP2','INM_ID','IAP_FOTO1','IAP_FOTO2',
                  'IAP_GEOREF_LATITUD','IAP_GEOREF_LONGITUD',
                  'PERIODO_ID1','MES_ID1','DIA_ID1','PERIODO_ID2','MES_ID2','DIA_ID2',
                  'IAP_STATUS','IAP_OBS1','IAP_OBS2','IAP_FECCERTIFIC','ONG_FECCERTIFIC2','ONG_FECCERTIFIC3',
                  'IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                  ->orderBy('IAP_ID','ASC')
                  ->paginate(50);
        if($regiap->count() <= 0){
            toastr()->error('No existen ONGS.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('nuevaIap');
        }
        return view('sicinar.iaps.verIap',compact('nombre','usuario','regiap','regentidades', 'regmunicipio', 'regrubro','regvigencia','reginmuebles','regtotactivas','regtotinactivas','regperiodos','regmeses','regdias','regfigurajur'));

    }

    public function actionVerIap5(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                        ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        $regmunicipio = regMunicipioModel::join('ONG_CAT_ENTIDADES_FED',
                                                'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                'ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',
                                 'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                 'ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[15])
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                        ->orderBy('RUBRO_ID','asc')
                        ->get();   
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->orderBy('FIGJURIDICA_ID','asc')
                        ->get();                                        
        $regvigencia  = regVigenciaModel::select('ANIO_ID', 'ANIO_DESC')->get();
        $reginmuebles = regInmuebleedoModel::select('INM_ID','INM_DESC')->get(); 
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();         
        $regiap = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_DOM1','IAP_DOM2','IAP_DOM3','MUNICIPIO_ID',
                  'ENTIDADFEDERATIVA_ID','RUBRO_ID','FIGJURIDICA_ID','IAP_REGCONS','IAP_RFC','IAP_CP',
                  'IAP_FECCONS','ONG_FECCONS2','ONG_FECCONS3','IAP_TELEFONO',
                  'IAP_EMAIL','IAP_SWEB','IAP_PRES','IAP_REPLEGAL','IAP_SRIO','IAP_TESORERO','IAP_OBJSOC',
                  'ANIO_ID','IAP_FVP','IAP_FVP2','INM_ID','IAP_FOTO1','IAP_FOTO2','IAP_GEOREF_LATITUD',
                  'IAP_GEOREF_LONGITUD',
                  'PERIODO_ID1','MES_ID1','DIA_ID1','PERIODO_ID2','MES_ID2','DIA_ID2',
                  'IAP_STATUS','IAP_OBS1','IAP_OBS2','IAP_FECCERTIFIC','ONG_FECCERTIFIC2','ONG_FECCERTIFIC3',
                  'IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                  ->where('IAP_ID',$arbol_id)
                  ->orderBy('IAP_ID','ASC')
                  ->paginate(30);
        if($regiap->count() <= 0){
            toastr()->error('No existe ONGS.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.iaps.verIap5',compact('nombre','usuario','regiap','regentidades','regmunicipio','regrubro','regvigencia','reginmuebles','regperiodos','regmeses','regdias','regfigurajur'));
    }


    public function actionEditarIap($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')         
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('ONG_CAT_ENTIDADES_FED','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[15])
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                        ->orderBy('RUBRO_ID','asc')
                        ->get();   
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->orderBy('FIGJURIDICA_ID','asc')
                        ->get();                                        
        $regvigencia  = regVigenciaModel::select('ANIO_ID', 'ANIO_DESC')->get();
        $reginmuebles = regInmuebleedoModel::select('INM_ID','INM_DESC')->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();         
        $regiap = regIapModel::select('IAP_ID', 'IAP_DESC', 'IAP_DOM1','IAP_DOM2','IAP_DOM3','MUNICIPIO_ID',
                  'ENTIDADFEDERATIVA_ID','RUBRO_ID','FIGJURIDICA_ID','IAP_REGCONS','IAP_RFC','IAP_CP',
                  'IAP_FECCONS','ONG_FECCONS2','ONG_FECCONS3','IAP_TELEFONO',
                  'IAP_EMAIL','IAP_SWEB','IAP_PRES','IAP_REPLEGAL','IAP_SRIO','IAP_TESORERO','IAP_OBJSOC',
                  'PERIODO_ID1','MES_ID1','DIA_ID1','PERIODO_ID2','MES_ID2','DIA_ID2',                  
                  'IAP_OBS1','IAP_OBS2','IAP_STATUS','IAP_FECCERTIFIC','ONG_FECCERTIFIC2','ONG_FECCERTIFIC3',
                  'IAP_GEOREF_LATITUD','IAP_GEOREF_LONGITUD', 
                  'ANIO_ID','IAP_FVP','IAP_FVP2','INM_ID','IAP_FOTO1','IAP_FOTO2','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                 ->where('IAP_ID',$id)
                 ->orderBy('IAP_ID','ASC')
                 ->first();
        if($regiap->count() <= 0){
            toastr()->error('No existen registros de ONGS.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.iaps.editarIap',compact('nombre','usuario','regiap','regentidades','regmunicipio','regrubro','regvigencia','reginmuebles','regperiodos','regmeses','regdias','regfigurajur'));

    }

    public function actionActualizarIap(iapsRequest $request, $id){
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
        $regiap = regIapModel::where('IAP_ID',$id);
        if($regiap->count() <= 0)
            toastr()->error('No existe ONG.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*************** Actualizar ********************************/
            //xiap_feccons =null;
            //if(!empty($request->periodo_d1) and !empty($request->mes_d1) and !empty($request->dia_d1) ){
            //    //toastr()->error('muy bien 1....................','¡ok...........!',['positionClass' => 'toast-bottom-right']);
            //    $mes1 = regMesesModel::ObtMes($request->mes_id1);
            //    $dia1 = regDiasModel::ObtDia($request->dia_id1);                
                //xiap_feccons = $dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1;
            //}   //endif
            //if(!empty($request->periodo_d2) and !empty($request->mes_d2) and !empty($request->dia_d2) ){
            //    $mes2 = regMesesModel::ObtMes($request->mes_id2);
            //    $dia2 = regDiasModel::ObtDia($request->dia_id2);        
            //}

            //$mes1 = regMesesModel::ObtMes($request->mes_id1);
            //$dia1 = regDiasModel::ObtDia($request->dia_id1);                
            //$mes2 = regMesesModel::ObtMes($request->mes_id2);
            //$dia2 = regDiasModel::ObtDia($request->dia_id2);                    
            //dd('año 1:',$request->periodo_id1, ' año 2:',$request->periodo_id2,' mes1:',$mes1[0]->mes_mes,' dia1:',$dia1[0]->dia_desc,' mes2:',$mes2[0]->mes_mes, ' dia2:',$dia2[0]->dia_desc);
            $name1 =null;
            //dd('fecha constitución:',trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1));
            //if (isset($request->iap_foto1)||empty($request->iap_foto1)||is_null($reques->iap_foto1)) {
            //if (isset($request->iap_foto1)||empty($request->iap_foto1)||is_null($reques->iap_foto1)) {
            //if(isset($_PUT['submit'])){
            //   if(!empty($_PUT['iap_foto1'])){
            if(isset($request->iap_foto1)){
                if(!empty($request->iap_foto1)){
                    //Comprobar  si el campo foto1 tiene un archivo asignado:
                    if($request->hasFile('iap_foto1')){
                      $name1 = $id.'_'.$request->file('iap_foto1')->getClientOriginalName(); 
                      //sube el archivo a la carpeta del servidor public/images/
                      $request->file('iap_foto1')->move(public_path().'/images/', $name1);
                    }
                }
            }
            $name2 =null;
            if (isset($request->iap_foto2) and !empty($request->iap_foto2) ) {
               //Comprobar  si el campo foto2 tiene un archivo asignado:        
               if($request->hasFile('iap_foto2')){
                   $name2 = $id.'_'.$request->file('iap_foto2')->getClientOriginalName(); 
                   //sube el archivo a la carpeta del servidor public/images/
                   $request->file('iap_foto2')->move(public_path().'/images/', $name2);
               }
            }
            $regiap = regIapModel::where('IAP_ID',$id)        
                      ->update([                
                'IAP_DESC'      => substr(trim(strtoupper($request->iap_desc)),0,159),
                'IAP_DOM1'      => substr(trim(strtoupper($request->iap_dom1)),0,149),
                'IAP_DOM2'      => substr(trim(strtoupper($request->iap_dom2)),0,149),
                'IAP_DOM3'      => substr(trim(strtoupper($request->iap_dom3)),0,149),
                //'IAP_OTRAREF'   => substr(trim(strtoupper($request->iap_otraref)),0,149),
                'ENTIDADFEDERATIVA_ID' => $request->entidadfederativa_id,                
                'MUNICIPIO_ID'  => $request->municipio_id,
                'RUBRO_ID'      => $request->rubro_id,
                'FIGJURIDICA_ID'=> $request->FIGJURIDICA_id,
                'IAP_REGCONS'   => substr(trim(strtoupper($request->iap_regcons)),0,49),
                'IAP_RFC'       => substr(trim(strtoupper($request->iap_rfc)),0,17),
                'IAP_CP'        => $request->iap_cp,
                //'IAP_FECCONS'   => date('Y/m/d', strtotime($request->iap_feccons)), //$request->iap_feccons
                //'IAP_FECCONS'   => date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) )),
                //'IAP_FECCONS2'  => trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1), 
                //'PERIODO_ID1'   => $request->periodo_id1,
                //'MES_ID1'       => $request->mes_id1,
                //'DIA_ID1'       => $request->dia_id1,                
                //'IAP_FECCONS2'  => substr(trim($request->iap_feccons2),0,10),

                'ANIO_ID'       => $request->anio_id,                
                //'IAP_FVP'       => date('Y/m/d', strtotime($request->iap_fvp)),
                //'IAP_FVP'       => date('Y/m/d', strtotime(trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2) )),
                //'IAP_FVP2'      => trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2),
                //'PERIODO_ID2'   => $request->periodo_id2,
                //'MES_ID2'       => $request->mes_id2,
                //'DIA_ID2'       => $request->dia_id2,
                'IAP_FVP2'      => substr(trim($request->iap_fvp2),0,10),

                'INM_ID'        => $request->inm_id,
                'IAP_TELEFONO'  => substr(trim(strtoupper($request->iap_telefono)),0,59),
                'IAP_EMAIL'     => substr(trim(strtolower($request->iap_email)),0,149),
                'IAP_SWEB'      => substr(trim(strtolower($request->iap_sweb)),0,99),
                'IAP_PRES'      => substr(trim(strtoupper($request->iap_pres)),0,79),
                'IAP_REPLEGAL'  => substr(trim(strtoupper($request->iap_replegal)),0,149),
                'IAP_SRIO'      => substr(trim(strtoupper($request->iap_srio)),0,79),
                'IAP_TESORERO'  => substr(trim(strtoupper($request->iap_tesorero)),0,79),
                'IAP_OBJSOC'    => substr(trim(strtoupper($request->iap_objsoc)),0,799),
                'IAP_OBS1'      => substr(trim(strtoupper($request->iap_obs1)),0,299),        
                'IAP_GEOREF_LATITUD' => $request->iap_georef_latitud,
                'IAP_GEOREF_LONGITUD'=> $request->iap_georef_longitud,
                'IAP_STATUS'    => $request->iap_status, 

                'IP_M'          => $ip,
                'LOGIN_M'       => $nombre,
                'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')                                
                              ]);
            toastr()->success('ONG actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       146;    //Actualizar IAPS        
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                             'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/

        return redirect()->route('verIap');

    }

    public function actionEditarIap5($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')                
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('ONG_CAT_ENTIDADES_FED',
                  'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',
                            'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID',
                            'ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[15])
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                        ->orderBy('RUBRO_ID','asc')
                        ->get();     
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->orderBy('FIGJURIDICA_ID','asc')
                        ->get();                                        
        $regvigencia  = regVigenciaModel::select('ANIO_ID', 'ANIO_DESC')->get();
        $reginmuebles = regInmuebleedoModel::select('INM_ID','INM_DESC')->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();         
        $regiap = regIapModel::select('IAP_ID', 'IAP_DESC', 'IAP_DOM1','IAP_DOM2','IAP_DOM3','MUNICIPIO_ID',
                  'ENTIDADFEDERATIVA_ID','RUBRO_ID','FIGJURIDICA_ID','IAP_REGCONS','IAP_RFC','IAP_CP','IAP_FECCONS',
                  'ONG_FECCONS2','ONG_FECCONS3','IAP_TELEFONO',
                  'IAP_EMAIL','IAP_SWEB','IAP_PRES','IAP_REPLEGAL','IAP_SRIO','IAP_TESORERO','IAP_OBJSOC',
                  'PERIODO_ID1','MES_ID1','DIA_ID1','PERIODO_ID2','MES_ID2','DIA_ID2',                  
                  'IAP_OBS1','IAP_OBS2','IAP_STATUS','IAP_FECCERTIFIC','ONG_FECCERTIFIC2','ONG_FECCERTIFIC3',
                  'IAP_GEOREF_LATITUD', 'IAP_GEOREF_LONGITUD', 
                  'ANIO_ID','IAP_FVP','IAP_FVP2','INM_ID','IAP_FOTO1','IAP_FOTO2','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                  ->where('IAP_ID',$id)
                  ->first();
        if($regiap->count() <= 0){
            toastr()->error('No existe IAP.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('nuevaIap');
        }
        return view('sicinar.iaps.editarIap5',compact('nombre','usuario','regiap','regentidades','regmunicipio','regrubro','regvigencia','reginmuebles','regperiodos','regmeses','regdias','regfigurajur'));

    }

    public function actionActualizarIap5(iaps5Request $request, $id){
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
        $regiap = regIapModel::where('IAP_ID',$id);
        if($regiap->count() <= 0)
            toastr()->error('No existe ONG.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            /****************** Actualizar *********************************/
            $regiap = regIapModel::where('IAP_ID',$id)        
                      ->update([                
                                'IAP_DOM2'      => substr(trim(strtoupper($request->iap_dom2)),0,149),
                                'IAP_DOM3'      => substr(trim(strtoupper($request->iap_dom3)),0,149),
                                'IAP_RFC'       => substr(trim(strtoupper($request->iap_rfc)),0,17),
                                'IAP_TELEFONO'  => substr(trim(strtoupper($request->iap_telefono)),0,59),
                                'IAP_EMAIL'     => substr(trim(strtolower($request->iap_email)),0,149),
                                'IAP_SWEB'      => substr(trim(strtolower($request->iap_sweb)),0,99),
                                'IAP_PRES'      => substr(trim(strtoupper($request->iap_pres)),0,79),
                                'IAP_REPLEGAL'  => substr(trim(strtoupper($request->iap_replegal)),0,149),
                                'IAP_SRIO'      => substr(trim(strtoupper($request->iap_srio)),0,79),
                                'IAP_TESORERO'  => substr(trim(strtoupper($request->iap_tesorero)),0,79),
                                'IAP_GEOREF_LATITUD' => $request->iap_georef_latitud,
                                'IAP_GEOREF_LONGITUD'=> $request->iap_georef_longitud,

                                'IP_M'          => $ip,
                                'LOGIN_M'       => $nombre,
                                'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')                                
                                ]);
            toastr()->success('ONG actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       146;    //Actualizar
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                $regbitacora= regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                              ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
                                       'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 
                                       'FOLIO' => $id])
                              ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }   /***************** Actualizar IAP **************************************/

        return redirect()->route('verIap5');

    }


    public function actionBorrarIap($id){
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

        /************ Elimina la IAP **************************************/
        $regiap = regIapModel::select('IAP_ID','IAP_DESC','IAP_DOM1','IAP_DOM2','IAP_DOM3','MUNICIPIO_ID', 
            'ENTIDADFEDERATIVA_ID','RUBRO_ID','FIGJURIDICA_ID','IAP_REGCONS','IAP_RFC','IAP_CP',
            'IAP_FECCONS','ONG_FECCONS2','ONG_FECCONS3',
            'IAP_TELEFONO','IAP_EMAIL',
            'IAP_SWEB','IAP_PRES','IAP_REPLEGAL','IAP_SRIO','IAP_TESORERO','IAP_OBJSOC','IAP_OBS1','IAP_OBS2',
            'IAP_STATUS','IAP_FECCERTIFIC','ONG_FECCERTIFIC2','ONG_FECCERTIFIC3',
            'IAP_GEOREF_LATITUD', 'IAP_GEOREF_LONGITUD','ANIO_ID','IAP_FVP','IAP_FVP2',
            'INM_ID','IAP_FOTO1','IAP_FOTO2','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                   ->where('IAP_ID',$id);
        //                    ->find('RUBRO_ID',$id);
        if($regiap->count() <= 0)
            toastr()->error('No existe ONG.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regiap->delete();
            toastr()->success('ONG eliminada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       147;     // Baja de IAP

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
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
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP           = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar  la IAP **********************************/
        
        return redirect()->route('verIap');
    }    

    // exportar a formato catalogo de IAPs a formato excel
    public function exportCatIapsExcel(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        
        
        /************ Bitacora inicia *************************************/ 
        setlocale(LC_TIME, "spanish");        
        $xip          = session()->get('ip');
        $xperiodo_id  = (int)date('Y');
        $xprograma_id = 1;
        $xmes_id      = (int)date('m');
        $xproceso_id  =         3;
        $xfuncion_id  =      3001;
        $xtrx_id      =       148;            // Exportar a formato Excel
        $id           =         0;

        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                        ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
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
                        ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
            ->update([
                'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                'IP_M' => $regbitacora->IP           = $ip,
                'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
            ]);
            toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }
        /************ Bitacora termina *************************************/  

        return Excel::download(new ExcelExportCatIAPS, 'Cat_ONGS_'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato catalogo de IAPS a formato PDF
    public function exportCatIapsPdf(){
        set_time_limit(0);
        ini_set("memory_limit",-1);
        ini_set('max_execution_time', 0);

        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        /************ Bitacora inicia *************************************/ 
        setlocale(LC_TIME, "spanish");        
        $xip          = session()->get('ip');
        $xperiodo_id  = (int)date('Y');
        $xprograma_id = 1;
        $xmes_id      = (int)date('m');
        $xproceso_id  =         3;
        $xfuncion_id  =      3001;
        $xtrx_id      =       143;       //Exportar a formato PDF
        $id           =         0;

        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                       'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                         'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                         'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                        ->max('NO_VECES');
            $xno_veces = $xno_veces+1;                        
            //*********** Termina de obtener el no de veces *****************************         
            $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
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

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')     
                                           ->get();
        $regmunicipio = regMunicipioModel::select('ENTIDADFEDERATIVAID', 'MUNICIPIOID', 'MUNICIPIONOMBRE')
                                           ->wherein('ENTIDADFEDERATIVAID',[15])
                                           ->get();                           
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')
                                       ->get();                         
        $regfigurajur = regFigjuridicaModel::select('FIGJURIDICA_ID','FIGJURIDICA_DESC')
                        ->get();                                                       
        $regiap       = regIapModel::select('IAP_ID','IAP_DESC','IAP_DOM1','IAP_DOM2','IAP_DOM3', 'IAP_TELEFONO',
                                      'IAP_STATUS', 'IAP_FECREG')
                                     ->orderBy('IAP_ID','ASC')
                                     ->get();                               
        if($regiap->count() <= 0){
            toastr()->error('No existen registros en el catalogo de IAPS.','Uppss!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('verIap');
        }
        $pdf = PDF::loadView('sicinar.pdf.catiapsPDF', compact('nombre','usuario','regentidades','regmunicipio','regrubro','regiap','regfigurajur'));
        //$options = new Options();
        //$options->set('defaultFont', 'Courier');
        //$pdf->set_option('defaultFont', 'Courier');
        $pdf->setPaper('A4', 'landscape');      
        //$pdf->set('defaultFont', 'Courier');          
        //$pdf->setPaper('A4','portrait');

        // Output the generated PDF to Browser
        return $pdf->stream('CatalogoDeONGS');
    }

    // Gráfica de ONGS por estado
    public function IapxEdo(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxedo=regIapModel::join('ONG_CAT_ENTIDADES_FED',[['ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=','ONGS.ENTIDADFEDERATIVA_ID'],['ONGS.IAP_ID','<>',0]])
                         ->selectRaw('COUNT(*) AS TOTALXEDO')
                               ->get();

        $regiap=regIapModel::join('ONG_CAT_ENTIDADES_FED',[['ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=','ONGS.ENTIDADFEDERATIVA_ID'],['ONGS.IAP_ID','<>',0]])
                      ->selectRaw('ONGS.ENTIDADFEDERATIVA_ID, ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC AS ESTADO, COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.ENTIDADFEDERATIVA_ID', 'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC')
                        ->orderBy('ONGS.ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.iapxedo',compact('regiap','regtotxedo','nombre','usuario','rango'));
    }


    // Gráfica demanda de transacciones (Bitacora)
    public function Bitacora(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');

        // http://www.chartjs.org/docs/#bar-chart
        $regbitatxmes=regBitacoraModel::join('ONG_CAT_PROCESOS','ONG_CAT_PROCESOS.PROCESO_ID' ,'=','ONG_BITACORA.PROCESO_ID')
                                   ->join('ONG_CAT_FUNCIONES','ONG_CAT_FUNCIONES.FUNCION_ID','=','ONG_BITACORA.FUNCION_ID')
                                   ->join('ONG_CAT_TRX'      ,'ONG_CAT_TRX.TRX_ID'          ,'=','ONG_BITACORA.TRX_ID')
                                   ->join('ONG_CAT_MESES'    ,'ONG_CAT_MESES.MES_ID'        ,'=','ONG_BITACORA.MES_ID')
                         ->select('ONG_BITACORA.MES_ID','ONG_CAT_MESES.MES_DESC')
                         ->selectRaw('COUNT(*) AS TOTALGENERAL')
                         ->groupBy('ONG_BITACORA.MES_ID','ONG_CAT_MESES.MES_DESC')
                         ->orderBy('ONG_BITACORA.MES_ID','asc')
                         ->get();        
        $regbitatot=regBitacoraModel::join('ONG_CAT_PROCESOS','ONG_CAT_PROCESOS.PROCESO_ID' ,'=','ONG_BITACORA.PROCESO_ID')
                                   ->join('ONG_CAT_FUNCIONES','ONG_CAT_FUNCIONES.FUNCION_ID','=','ONG_BITACORA.FUNCION_ID')
                                   ->join('ONG_CAT_TRX'      ,'ONG_CAT_TRX.TRX_ID'          ,'=','ONG_BITACORA.TRX_ID')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 1 THEN 1 END) AS M01')  
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 2 THEN 1 END) AS M02')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 3 THEN 1 END) AS M03')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 4 THEN 1 END) AS M04')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 5 THEN 1 END) AS M05')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 6 THEN 1 END) AS M06')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 7 THEN 1 END) AS M07')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 8 THEN 1 END) AS M08')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 9 THEN 1 END) AS M09')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID =10 THEN 1 END) AS M10')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID =11 THEN 1 END) AS M11')
                         ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID =12 THEN 1 END) AS M12')
                         ->selectRaw('COUNT(*) AS TOTALGENERAL')
                         ->get();

        $regbitacora=regBitacoraModel::join('ONG_CAT_PROCESOS' ,'ONG_CAT_PROCESOS.PROCESO_ID' ,'=','ONG_BITACORA.PROCESO_ID')
                                     ->join('ONG_CAT_FUNCIONES','ONG_CAT_FUNCIONES.FUNCION_ID','=','ONG_BITACORA.FUNCION_ID')
                                     ->join('ONG_CAT_TRX'      ,'ONG_CAT_TRX.TRX_ID'          ,'=','ONG_BITACORA.TRX_ID')
                    ->select('ONG_BITACORA.PERIODO_ID', 'ONG_BITACORA.PROGRAMA_ID', 'ONG_BITACORA.PROCESO_ID', 
                                'ONG_CAT_PROCESOS.PROCESO_DESC', 'ONG_BITACORA.FUNCION_ID', 'ONG_CAT_FUNCIONES.FUNCION_DESC', 
                                'ONG_BITACORA.TRX_ID', 'ONG_CAT_TRX.TRX_DESC')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 1 THEN 1 END) AS ENE')  
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 2 THEN 1 END) AS FEB')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 3 THEN 1 END) AS MAR')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 4 THEN 1 END) AS ABR')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 5 THEN 1 END) AS MAY')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 6 THEN 1 END) AS JUN')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 7 THEN 1 END) AS JUL')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 8 THEN 1 END) AS AGO')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID = 9 THEN 1 END) AS SEP')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID =10 THEN 1 END) AS OCT')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID =11 THEN 1 END) AS NOV')
                    ->selectRaw('SUM(CASE WHEN ONG_BITACORA.MES_ID =12 THEN 1 END) AS DIC')                   
                    ->selectRaw('COUNT(*) AS SUMATOTAL')
                    ->groupBy('ONG_BITACORA.PERIODO_ID', 'ONG_BITACORA.PROGRAMA_ID','ONG_BITACORA.PROCESO_ID', 
                              'ONG_CAT_PROCESOS.PROCESO_DESC','ONG_BITACORA.FUNCION_ID','ONG_CAT_FUNCIONES.FUNCION_DESC', 
                              'ONG_BITACORA.TRX_ID', 'ONG_CAT_TRX.TRX_DESC')
                    ->orderBy('ONG_BITACORA.PERIODO_ID', 'ONG_BITACORA.PROGRAMA_ID','ONG_BITACORA.PROCESO_ID', 
                              'ONG_CAT_PROCESOS.PROCESO_DESC','ONG_BITACORA.FUNCION_ID','ONG_CAT_FUNCIONES.FUNCION_DESC',
                              'ONG_BITACORA.TRX_ID', 'ONG_CAT_TRX.TRX_DESC','asc')
                    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.bitacora',compact('regbitatxmes','regbitacora','regbitatot','nombre','usuario','rango'));
    }

    // Gráfica de ONGS por municipio
    public function IapxMpio(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');  
        $arbol_id     = session()->get('arbol_id');              

        $regtotxmpio=regIapModel::join('ONG_CAT_MUNICIPIOS_SEDESEM',[['ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
                                                            ['ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','ONGS.MUNICIPIO_ID'],['ONGS.IAP_ID','<>',0]])
                         ->selectRaw('COUNT(*) AS TOTALXMPIO')
                               ->get();
        $regiap=regIapModel::join('ONG_CAT_MUNICIPIOS_SEDESEM',[['ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
                                                            ['ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','ONGS.MUNICIPIO_ID'],['ONGS.IAP_ID','<>',0]])
                      ->selectRaw('ONGS.MUNICIPIO_ID, ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE AS MUNICIPIO,COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.MUNICIPIO_ID', 'ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->orderBy('ONGS.MUNICIPIO_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.iapxmpio',compact('regiap','regtotxmpio','nombre','usuario','rango'));
    }

    // Gráfica de ONGS por Rubro social
    public function IapxRubro(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxrubro=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();
        $regiap=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('ONGS.RUBRO_ID,  ONG_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.RUBRO_ID','ONG_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('ONGS.RUBRO_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.iapxrubro',compact('regiap','regtotxrubro','nombre','usuario','rango'));
    }

    // Gráfica de ONGS por Figurajuridica
    public function IapxFiguraj(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxfigura=regIapModel::join('ONG_CAT_FIGURAJURIDICA','ONG_CAT_FIGURAJURIDICA.FIGJURIDICA_ID','=',
                                                                 'ONGS.FIGJURIDICA_ID')
                      ->selectRaw('COUNT(*) AS TOTALXFIGURAJURIDICA')
                            ->get();
        $regiap=regIapModel::join('ONG_CAT_FIGURAJURIDICA','ONG_CAT_FIGURAJURIDICA.FIGJURIDICA_ID','=',
                                                           'ONGS.FIGJURIDICA_ID')
                      ->selectRaw('ONGS.FIGJURIDICA_ID,  ONG_CAT_FIGURAJURIDICA.FIGJURIDICA_DESC AS FIGURA, 
                                   COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.FIGJURIDICA_ID','ONG_CAT_FIGURAJURIDICA.FIGJURIDICA_DESC')
                        ->orderBy('ONGS.FIGJURIDICA_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.iapxfigurajuridica',compact('regiap','regtotxfigura','nombre','usuario','rango'));
    }

    // Gráfica de IAP por Rubro social
    public function IapxRubro2(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxrubro=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();
        $regiap=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('ONGS.RUBRO_ID,  ONG_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.RUBRO_ID','ONG_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('ONGS.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.graficadeprueba',compact('regiap','regtotxrubro','nombre','usuario','rango'));
    }

    // Mapas
    public function Mapas(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxrubro=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();

        $regiap=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('ONGS.RUBRO_ID,  ONG_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.RUBRO_ID','ONG_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('ONGS.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapasdeprueba',compact('regiap','regtotxrubro','nombre','usuario','rango'));
    }

    // Mapas
    public function Mapas2(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');                

        $regtotxrubro=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();

        $regiap=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('ONGS.RUBRO_ID,  ONG_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.RUBRO_ID','ONG_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('ONGS.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapasdeprueba2',compact('regiap','regtotxrubro','nombre','usuario','rango'));
    }

    // Mapas
    public function Mapas3(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');                

        $regtotxrubro=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();
        $regiap=regIapModel::join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                      ->selectRaw('ONGS.RUBRO_ID,  ONG_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('ONGS.RUBRO_ID','ONG_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('ONGS.RUBRO_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapasdeprueba3',compact('regiap','regtotxrubro','nombre','usuario','rango'));
    }

}
