<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\personalRequest;
use App\regIapModel;
use App\regPersonalModel;
use App\regBitacoraModel;
use App\regMunicipioModel;
use App\regEntidadesModel; 
use App\regEstudiosModel;
use App\regClaseempModel;
use App\regTipoempModel;
use App\regPeriodosaniosModel;
use App\regMesesModel;
use App\regDiasModel;

// Exportar a excel 
use App\Exports\ExportPersonalExcel;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class personalController extends Controller
{

    //public function LocalidadMunicipio(Request $request, $id){
    public function EntidadMunicipios(Request $request, $id){        
        return response()->json(regMunicipioModel::Municipios($id));
    }

    public function actionBuscarPersonal(Request $request)
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
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED',
                                                'JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',
                          'JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID',
                          'JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','ASC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','ASC')
                        ->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->get(); 
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                           
        $regestudios  = regEstudiosModel::select('GRADO_ESTUDIOS_ID','GRADO_ESTUDIOS_DESC')
                        ->get();  
        $regclaseemp  = regClaseempModel::select('CLASEEMP_ID','CLASEEMP_DESC')->get();  
        $regtipoemp   = regTipoempModel::select('TIPOEMP_ID','TIPOEMP_DESC')->get();  
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();                              
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $name  = $request->get('name');   
        //$email = $request->get('email');  
        //$bio   = $request->get('bio');    
        $regpersonal= regPersonalModel::orderBy('IAP_ID', 'ASC')
                      ->name($name)      //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                  //->email($email)      //Metodos personalizados
                  //->bio($bio)          //Metodos personalizados
                     ->paginate(30);
        if($regpersonal->count() <= 0){
            toastr()->error('No existe personal.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoPadron');
        }            
        return view('sicinar.personal.verPersonal', compact('nombre','usuario','regpersonal','regentidades','regmunicipio','regperiodos','regiap','regestudios','regmeses','regdias','regclaseemp','regtipoemp'));
    }


    public function actionnuevoPersonal(){
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
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                       'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',
                                 'JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                 'JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID',
                                 'JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','ASC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','ASC')
                        ->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->get(); 
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                          
        $regestudios  = regEstudiosModel::select('GRADO_ESTUDIOS_ID','GRADO_ESTUDIOS_DESC')
                        ->orderBy('GRADO_ESTUDIOS_DESC','ASC')
                        ->get();                             
        $regclaseemp  = regClaseempModel::select('CLASEEMP_ID','CLASEEMP_DESC')->get();  
        $regtipoemp   = regTipoempModel::select('TIPOEMP_ID','TIPOEMP_DESC')->get();                       
        if(session()->get('rango') !== '0'){                           
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->orderBy('IAP_DESC','ASC')
                        ->get();                                                        
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->orderBy('IAP_DESC','ASC')
                        ->where('IAP_ID',$arbol_id)
                        ->get();            
        }                                                
        $regpersonal    = regPersonalModel::select('PERIODO_ID','PROGRAMA_ID','FOLIO','IAP_ID','PRIMER_APELLIDO',
                          'SEGUNDO_APELLIDO','NOMBRES','NOMBRE_COMPLETO','CURP','FECHA_INGRESO',
                          'FECHA_INGRESO2','PERIODO_ID1','MES_ID1','DIA_ID1',
                          'FECHA_NACIMIENTO','FECHA_NACIMIENTO2','PERIODO_ID2','MES_ID2','DIA_ID2',
                          'SEXO','RFC','ID_OFICIAL','DOMICILIO','COLONIA','CP','ENTRE_CALLE','Y_CALLE',
                          'OTRA_REFERENCIA','TELEFONO','CELULAR','E_MAIL','ENTIDAD_NAC_ID','ENTIDAD_FED_ID',
                          'MUNICIPIO_ID','LOCALIDAD_ID','LOCALIDAD','EDO_CIVIL_ID','GRADO_ESTUDIOS_ID',
                          'PUESTO','TIPOEMP_ID','CLASEEMP_ID','SUELDO_MENSUAL','OBS_1','OBS_2','STATUS_1','STATUS_2',
                          'FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('IAP_ID','asc')
                        ->get();
        //dd($unidades);
        return view('sicinar.personal.nuevoPersonal',compact('regmunicipio','regentidades','regiap','regperiodos','regpersonal','regestudios','regmeses','regdias','regclaseemp','regtipoemp','nombre','usuario'));
    }

    public function actionAltanuevoPersonal(Request $request){
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

        // **************** validar duplicidad ******************************/
        setlocale(LC_TIME, "spanish");        
        $xperiodo_id  = (int)date('Y');        
        if(!empty($request->periodo_d1) and !empty($request->mes_d1) and !empty($request->dia_d1) ){
            //toastr()->error('muy bien 1....................','¡ok...........!',['positionClass' => 'toast-bottom-right']);
            $mes1 = regMesesModel::ObtMes($request->mes_id1);
            $dia1 = regDiasModel::ObtDia($request->dia_id1);                
            //xiap_feccons = $dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1;
        }   //endif
        if(!empty($request->periodo_d2) and !empty($request->mes_d2) and !empty($request->dia_d2) ){
            $mes2 = regMesesModel::ObtMes($request->mes_id2);
            $dia2 = regDiasModel::ObtDia($request->dia_id2);        
        }
        $mes1 = regMesesModel::ObtMes($request->mes_id1);
        $dia1 = regDiasModel::ObtDia($request->dia_id1);                
        $mes2 = regMesesModel::ObtMes($request->mes_id2);
        $dia2 = regDiasModel::ObtDia($request->dia_id2);                        

        $xnombre_completo = substr(strtoupper(trim($request->primer_apellido)).' '.strtoupper(trim($request->segundo_apellido)).' '.strtoupper(trim($request->nombres)),0,99);
        //$mes1 = regMesesModel::ObtMes($request->mes_id1);
        //$dia1 = regDiasModel::ObtDia($request->dia_id1);
        //$mes2 = regMesesModel::ObtMes($request->mes_id2);
        //$dia2 = regDiasModel::ObtDia($request->dia_id2);        
        // *************** Validar triada ***********************************/
        $triada = regPersonalModel::where(['NOMBRE_COMPLETO' => $xnombre_completo, 
                                         'CURP' => substr(strtoupper(trim($request->curp)),0,17),
                                         'MUNICIPIO_ID' => $request->municipio_id])
                  ->get();
        if($triada->count() >= 1)
            //toastr()->error('Ya existe un Personal:'.$nombre_completo.' CURP:'.$request->curp.' Municipio:'.$request->municipio_id.'--','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
            //return back()->withInput()->withErrors(['PRIMER_APELLIDO' => 'El PRIMER APELLIDO '.$request->PRIMER_APELLIDO.' contiene caracteres inválidos. Favor de verificar.']);
            //return back()->withInput()->withErrors(['NOMBRE_COMPLETO' => 'Personal '.$xnombre_completo.'CURP' => 'Con CURP '.$request->curp.'MUNICIPIO_ID' => 'Clave de municipio '.$request->municipio_id.' Ya existe. Por favor verificar.']);
            return back()->withInput()->withErrors(['NOMBRE_COMPLETO' => 'Persona '.$xnombre_completo.' Ya existe una persona con el mismo nombre, curp y municipio (triada). Por favor verificar.']);
        else{        
            // *************** Validar curp ***********************************/
            $dupcurp = regPersonalModel::where('CURP',substr(strtoupper(trim($request->curp)),0,17))
                       ->get();
            if($dupcurp->count() >= 1)
                return back()->withInput()->withErrors(['CURP' => ' CURP '.$request->curp.' Ya existe otra persona con el mismo curp. Por favor verificar.']);
            else{                    
                //**************************** Alta ********************************/
                $folio = regPersonalModel::max('FOLIO');
                $folio = $folio + 1;
                $nuevoPersonal = new regPersonalModel();
                $nuevoPersonal->PERIODO_ID       = $xperiodo_id;
                $nuevoPersonal->FOLIO            = $folio;
                //$nuevoPersonal->PERIODO_ID       = $request->periodo_id;        
                $nuevoPersonal->IAP_ID           = $request->iap_id;
                $nuevoPersonal->PRIMER_APELLIDO  = substr(strtoupper(trim($request->primer_apellido)) ,0,79);
                $nuevoPersonal->SEGUNDO_APELLIDO = substr(strtoupper(trim($request->segundo_apellido)),0,79);
                $nuevoPersonal->NOMBRES          = substr(strtoupper(trim($request->nombres)),0,79);
                $nuevoPersonal->NOMBRE_COMPLETO  = substr(strtoupper(trim($request->primer_apellido)).' '.strtoupper(trim($request->segundo_apellido)).' '.strtoupper(trim($request->nombres)),0,99);
                $nuevoPersonal->CURP             = substr(strtoupper(trim($request->curp)),0,17);
                //$nuevoPersonal->FECHA_NACIMIENTO = date('Y/m/d', strtotime($request->fecha_nacimiento));
                $nuevoPersonal->FECHA_NACIMIENTO = date('Y/m/d', strtotime(trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2) ));
                $nuevoPersonal->FECHA_NACIMIENTO2= trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2);
                $nuevoPersonal->PERIODO_ID2      = $request->periodo_id2;                
                $nuevoPersonal->MES_ID2          = $request->mes_id2;                
                $nuevoPersonal->DIA_ID2          = $request->dia_id2;                        
                $nuevoPersonal->SEXO             = $request->sexo;

                $nuevoPersonal->DOMICILIO        = substr(strtoupper(trim($request->domicilio)),0,149);        
                $nuevoPersonal->COLONIA          = substr(strtoupper(trim($request->colonia)),0,79);        
                $nuevoPersonal->LOCALIDAD        = substr(strtoupper(trim($request->localidad)),0,149);                
                $nuevoPersonal->CP               = $request->cp; 
                $nuevoPersonal->MUNICIPIO_ID     = $request->municipio_id;
                $nuevoPersonal->ENTIDAD_FED_ID   = $request->entidad_fed_id;
                //$nuevoPersonal->FECHA_INGRESO    = date('Y/m/d', strtotime($request->fecha_ingreso));
                $nuevoPersonal->FECHA_INGRESO    = date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) ));
                $nuevoPersonal->FECHA_INGRESO2   = trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1);
                $nuevoPersonal->PERIODO_ID1      = $request->periodo_id1;                
                $nuevoPersonal->MES_ID1          = $request->mes_id1;                
                $nuevoPersonal->DIA_ID1          = $request->dia_id1;                
                $nuevoPersonal->TELEFONO         = substr(strtoupper(trim($request->telefono)),0,29);        
                $nuevoPersonal->PUESTO           = substr(strtoupper(trim($request->puesto)),0,149);        
                $nuevoPersonal->SUELDO_MENSUAL   = $request->sueldo_mensual;        
                $nuevoPersonal->GRADO_ESTUDIOS_ID= $request->grado_estudios_id;        
                $nuevoPersonal->CLASEEMP_ID      = $request->claseemp_id;        
                $nuevoPersonal->TIPOEMP_ID       = $request->tipoemp_id;                
                $nuevoPersonal->OBS_1            = substr(strtoupper(trim($request->obs_1)),0,299);   

                $nuevoPersonal->IP               = $ip;
                $nuevoPersonal->LOGIN            = $nombre;         // Usuario ;
                $nuevoPersonal->save();
                if($nuevoPersonal->save() == true){
                    toastr()->success('Personal dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                    /************ Bitacora inicia *************************************/ 
                    setlocale(LC_TIME, "spanish");        
                    $xip          = session()->get('ip');
                    $xperiodo_id  = (int)date('Y');
                    $xprograma_id = 1;
                    $xmes_id      = (int)date('m');
                    $xproceso_id  =         3;
                    $xfuncion_id  =      3008;
                    $xtrx_id      =         7;    //Alta
                    $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                    'FECHA_M', 'IP_M', 'LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $folio])
                               ->get();
                    if($regbitacora->count() <= 0){              // Alta
                        $nuevoregBitacora = new regBitacoraModel();              
                        $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                        $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                        $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                        $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                        $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                        $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                        $nuevoregBitacora->FOLIO      = $folio;          // Folio    
                        $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                        $nuevoregBitacora->IP         = $folio;          // Folio
                        $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                        $nuevoregBitacora->save();
                        if($nuevoregBitacora->save() == true)
                            toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                        else
                            toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                    }else{                   
                        //*********** Obtine el no. de veces *****************************
                        $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                                      'FOLIO' => $folio])
                                     ->max('NO_VECES');
                        $xno_veces = $xno_veces+1;                        
                        //*********** Termina de obtener el no de veces *****************************         
                        $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                            'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                            'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $folio])
                                   ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                        toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    }
                    /************ Bitacora termina *************************************/ 

                    //return redirect()->route('nuevoPadron');
                    //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','estructura','id_estructura','rango','preguntas','apartados'));
                }else{
                    toastr()->error('Error al dar de alta la Persona. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                    //return back();
                    //return redirect()->route('nuevoProceso');
                }   /**************** Termina de dar de alta ********************************/
            }       /**************** Termina de validar duplicidad del CURP ****************/
        }           /**************** Termina de validar duplicidad triada *****************/

        return redirect()->route('verPersonal');
    }

    public function actionverPersonal(){
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
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                       'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->get(); 
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                          
        $regestudios  = regEstudiosModel::select('GRADO_ESTUDIOS_ID','GRADO_ESTUDIOS_DESC')
                        ->get();                           
        $regclaseemp  = regClaseempModel::select('CLASEEMP_ID','CLASEEMP_DESC')->get();  
        $regtipoemp   = regTipoempModel::select('TIPOEMP_ID','TIPOEMP_DESC')->get();                      
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->orderBy('IAP_DESC','ASC')
                        ->get();   
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){        
            $regpersonal= regPersonalModel::select('PERIODO_ID','PROGRAMA_ID','FOLIO','IAP_ID','PRIMER_APELLIDO',
                          'SEGUNDO_APELLIDO','NOMBRES','NOMBRE_COMPLETO','CURP','FECHA_INGRESO',
                          'FECHA_INGRESO2','PERIODO_ID1','MES_ID1','DIA_ID1',
                          'FECHA_NACIMIENTO','FECHA_NACIMIENTO2','PERIODO_ID2','MES_ID2','DIA_ID2',
                          'SEXO','RFC','ID_OFICIAL','DOMICILIO','COLONIA','CP','ENTRE_CALLE','Y_CALLE',
                          'OTRA_REFERENCIA','TELEFONO','CELULAR','E_MAIL','ENTIDAD_NAC_ID','ENTIDAD_FED_ID',
                          'MUNICIPIO_ID','LOCALIDAD_ID','LOCALIDAD','EDO_CIVIL_ID','GRADO_ESTUDIOS_ID',
                          'PUESTO','TIPOEMP_ID','CLASEEMP_ID','SUELDO_MENSUAL','OBS_1','OBS_2','STATUS_1','STATUS_2',
                          'FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                         ->orderBy('PERIODO_ID','asc')
                         ->orderBy('IAP_ID','asc')
                         ->paginate(30);
        }else{                          
            $regpersonal= regPersonalModel::select('PERIODO_ID','PROGRAMA_ID','FOLIO','IAP_ID','PRIMER_APELLIDO',
                          'SEGUNDO_APELLIDO','NOMBRES','NOMBRE_COMPLETO','CURP','FECHA_INGRESO',
                          'FECHA_INGRESO2','PERIODO_ID1','MES_ID1','DIA_ID1',
                          'FECHA_NACIMIENTO','FECHA_NACIMIENTO2','PERIODO_ID2','MES_ID2','DIA_ID2',
                          'SEXO','RFC','ID_OFICIAL','DOMICILIO','COLONIA','CP','ENTRE_CALLE','Y_CALLE',
                          'OTRA_REFERENCIA','TELEFONO','CELULAR','E_MAIL','ENTIDAD_NAC_ID','ENTIDAD_FED_ID',
                          'MUNICIPIO_ID','LOCALIDAD_ID','LOCALIDAD','EDO_CIVIL_ID','GRADO_ESTUDIOS_ID',
                          'PUESTO','TIPOEMP_ID','CLASEEMP_ID','SUELDO_MENSUAL','OBS_1','OBS_2','STATUS_1','STATUS_2',
                          'FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                         ->where('IAP_ID',$arbol_id)
                         ->paginate(30);            
        }
        if($regpersonal->count() <= 0){
            toastr()->error('No existe Personal.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoPersonal');
        }
        return view('sicinar.personal.verPersonal',compact('nombre','usuario','regiap','regentidades', 'regmunicipio', 'regperiodos','regpersonal','regestudios','regmeses','regdias','regclaseemp','regtipoemp'));

    }


    public function actionEditarPersonal($id){
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
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                       'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',
                                 'JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                 'JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->get(); 
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                          
        $regestudios  = regEstudiosModel::select('GRADO_ESTUDIOS_ID','GRADO_ESTUDIOS_DESC')
                        ->orderBy('GRADO_ESTUDIOS_DESC','ASC')
                        ->get();                           
        $regclaseemp  = regClaseempModel::select('CLASEEMP_ID','CLASEEMP_DESC')->get();  
        $regtipoemp   = regTipoempModel::select('TIPOEMP_ID','TIPOEMP_DESC')->get();                       
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                            ->get();                                                        
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                        ->where('IAP_ID',$arbol_id)
                        ->get();            
        }                        
        $regpersonal  = regPersonalModel::select('PERIODO_ID','PROGRAMA_ID','FOLIO','IAP_ID','PRIMER_APELLIDO',
                        'SEGUNDO_APELLIDO','NOMBRES','NOMBRE_COMPLETO','CURP','FECHA_INGRESO',
                        'FECHA_INGRESO2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'FECHA_NACIMIENTO','FECHA_NACIMIENTO2','PERIODO_ID2','MES_ID2','DIA_ID2',
                        'SEXO','RFC','ID_OFICIAL','DOMICILIO','COLONIA','CP','ENTRE_CALLE','Y_CALLE',
                        'OTRA_REFERENCIA','TELEFONO','CELULAR','E_MAIL','ENTIDAD_NAC_ID','ENTIDAD_FED_ID',
                        'MUNICIPIO_ID','LOCALIDAD_ID','LOCALIDAD','EDO_CIVIL_ID','GRADO_ESTUDIOS_ID',
                        'PUESTO','TIPOEMP_ID','CLASEEMP_ID','SUELDO_MENSUAL','OBS_1','OBS_2','STATUS_1','STATUS_2',
                        'FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('FOLIO',$id)
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('IAP_ID','asc')
                        ->first();
        if($regpersonal->count() <= 0){
            toastr()->error('No existe persona en la plantilla de personal.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoPadron');
        }
        return view('sicinar.personal.editarPersonal',compact('nombre','usuario','regiap','regentidades','regmunicipio','regperiodos','regpersonal','regestudios','regmeses','regdias','regclaseemp','regtipoemp'));

    }

    public function actionActualizarPersonal(personalRequest $request, $id){
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
        $regpersonal = regPersonalModel::where('FOLIO',$id);
        if($regpersonal->count() <= 0)
            toastr()->error('No existe Personal.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*************** Actualizar ********************************/
            if(!empty($request->periodo_d1) and !empty($request->mes_d1) and !empty($request->dia_d1) ){
                //toastr()->error('muy bien 1....................','¡ok...........!',['positionClass' => 'toast-bottom-right']);
                $mes1 = regMesesModel::ObtMes($request->mes_id1);
                $dia1 = regDiasModel::ObtDia($request->dia_id1);                
                //xiap_feccons = $dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1;
            }   //endif
            if(!empty($request->periodo_d2) and !empty($request->mes_d2) and !empty($request->dia_d2) ){
                $mes2 = regMesesModel::ObtMes($request->mes_id2);
                $dia2 = regDiasModel::ObtDia($request->dia_id2);        
            }
            $mes1 = regMesesModel::ObtMes($request->mes_id1);
            $dia1 = regDiasModel::ObtDia($request->dia_id1);                
            $mes2 = regMesesModel::ObtMes($request->mes_id2);
            $dia2 = regDiasModel::ObtDia($request->dia_id2);                

            $regpersonal = regPersonalModel::where('FOLIO',$id)        
                         ->update([                
                //'PERIODO_ID'      => $request->periodo_id,
                'FECHA_INGRESO'   => date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) )),
                'FECHA_INGRESO2'  => trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1),
                'PERIODO_ID1'     => $request->periodo_id1,
                'MES_ID1'         => $request->mes_id1,
                'DIA_ID1'          => $request->dia_id1,

                'PRIMER_APELLIDO'  => substr(strtoupper(trim($request->primer_apellido)),0,79),
                'SEGUNDO_APELLIDO' => substr(strtoupper(trim($request->segundo_apellido)),0,79),
                'NOMBRES'          => substr(strtoupper(trim($request->nombres)),0,79),
                'NOMBRE_COMPLETO'  => substr(strtoupper(trim($request->primer_apellido)).' '.strtoupper(trim($request->segundo_apellido)).' '.strtoupper(trim($request->nombres)),0,99),
                'CURP'             => substr(strtoupper(trim($request->curp)),0,17),
                'SEXO'             => $request->sexo,
                //'FECHA_NACIMIENTO'=> date('Y/m/d', strtotime($request->fecha_nacimiento)), //$request->iap_feccons
                'FECHA_NACIMIENTO' => date('Y/m/d', strtotime(trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2) )),
                'FECHA_NACIMIENTO2'=> trim($dia2[0]->dia_desc.'/'.$mes2[0]->mes_mes.'/'.$request->periodo_id2),
                'PERIODO_ID2'      => $request->periodo_id2,
                'MES_ID2'          => $request->mes_id2,
                'DIA_ID2'          => $request->dia_id2,

                'ENTIDAD_FED_ID'   => $request->entidad_fed_id,                
                'MUNICIPIO_ID'     => $request->municipio_id,
                'GRADO_ESTUDIOS_ID'=> $request->grado_estudios_id,
                'TIPOEMP_ID'       => $request->tipoemp_id,
                'CLASEEMP_ID'      => $request->claseemp_id,

                'DOMICILIO'        => substr(strtoupper(trim($request->domicilio)),0,149),
                'COLONIA'          => substr(strtoupper(trim($request->colonia)),0,79),
                'LOCALIDAD'        => substr(strtoupper(trim($request->localidad)),0,149),
                'CP'               => $request->cp,
                
                'TELEFONO'         => substr(strtoupper(trim($request->telefono)),0,29),
                'PUESTO'           => substr(strtoupper(trim($request->puesto)),0,149),
                'SUELDO_MENSUAL'   => $request->sueldo_mensual,
                'OBS_1'            =>  substr(strtoupper(trim($request->obs_1)),0,299),
                'STATUS_1'         => $request->status_1,                

                'IP_M'             => $ip,
                'LOGIN_M'          => $nombre,
                'FECHA_M'          => date('Y/m/d')    //date('d/m/Y')                                
                              ]);
            toastr()->success('Plantilla de personal actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3008;
            $xtrx_id      =         8;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                                    'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 
                                                    'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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

        return redirect()->route('verPersonal');

    }


    public function actionBorrarPersonal($id){
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
        $regpersonal = regPersonalModel::where('FOLIO',$id);
        if($regpersonal->count() <= 0)
            toastr()->error('No existe Personal.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regpersonal->delete();
            toastr()->success('Personal eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3008;
            $xtrx_id      =         9;     // Baja 
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                             'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id,'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar  la IAP **********************************/
        
        return redirect()->route('verPersonal');
    }    

    // exportar a formato excel
    public function actionExportPersonalExcel(){
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
        $xfuncion_id  =      3008;
        $xtrx_id      =        10;            // Exportar a formato Excel
        $id           =         0;
        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 
                                                'IP_M', 'LOGIN_M')
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

        return Excel::download(new ExportPersonalExcel, 'Pesonal_'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato PDF
    public function actionExportPersonalPdf(){
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
        $xfuncion_id  =      3008;
        $xtrx_id      =        11;       //Exportar a formato PDF
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
                                           ->wherein('ENTIDADFEDERATIVAID',[9,15,22])
                                           ->get(); 
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->get();  
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                          
        $regestudios  = regEstudiosModel::select('GRADO_ESTUDIOS_ID','GRADO_ESTUDIOS_DESC')
                        ->get();
        $regclaseemp  = regClaseempModel::select('CLASEEMP_ID','CLASEEMP_DESC')->get();  
        $regtipoemp   = regTipoempModel::select('TIPOEMP_ID','TIPOEMP_DESC')->get();                          
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                        ->get();                                                        
        $regpersonal  = regPersonalModel::select('PERIODO_ID','PROGRAMA_ID','FOLIO','IAP_ID','PRIMER_APELLIDO',
                        'SEGUNDO_APELLIDO','NOMBRES','NOMBRE_COMPLETO','CURP','FECHA_INGRESO',
                        'FECHA_INGRESO2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'FECHA_NACIMIENTO','FECHA_NACIMIENTO2','PERIODO_ID2','MES_ID2','DIA_ID2',
                        'SEXO','RFC','ID_OFICIAL','DOMICILIO','COLONIA','CP','ENTRE_CALLE','Y_CALLE',
                        'OTRA_REFERENCIA','TELEFONO','CELULAR','E_MAIL','ENTIDAD_NAC_ID','ENTIDAD_FED_ID',
                        'MUNICIPIO_ID','LOCALIDAD_ID','LOCALIDAD','EDO_CIVIL_ID','GRADO_ESTUDIOS_ID',
                        'PUESTO','TIPOEMP_ID','CLASEEMP_ID','SUELDO_MENSUAL','OBS_1','OBS_2','STATUS_1','STATUS_2',
                        'FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('IAP_ID','asc')
                        ->get();                               
        if($regpersonal->count() <= 0){
            toastr()->error('No existe plantilla de personal.','Uppss!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('verPersonal');
        }
        $pdf = PDF::loadView('sicinar.pdf.personalPdf', compact('nombre','usuario','regentidades','regmunicipio','regiap','regperiodos','regpersonal','regestudios','regmeses','regdias','regclaseemp','regtipoemp'));
        //$options = new Options();
        //$options->set('defaultFont', 'Courier');
        //$pdf->set_option('defaultFont', 'Courier');
        $pdf->setPaper('A4', 'landscape');      
        //$pdf->set('defaultFont', 'Courier');          
        //$pdf->setPaper('A4','portrait');

        // Output the generated PDF to Browser
        return $pdf->stream('PlantillaDePersonal');
    }

    // Gráfica por estado
    public function actionPersonalxEdo(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxedo=regPersonalModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=',
                                                                'JP_METADATO_PERSONAL.ENTIDAD_FED_ID')
                    ->selectRaw('COUNT(*) AS TOTALXEDO')
                    ->get();
        $regpersonal =regPersonalModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=',
                                                                'JP_METADATO_PERSONAL.ENTIDAD_FED_ID')
                      ->selectRaw('JP_METADATO_PERSONAL.ENTIDAD_FED_ID, 
                                   JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC AS ESTADO, COUNT(*) AS TOTAL')
                      ->groupBy('JP_METADATO_PERSONAL.ENTIDAD_FED_ID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC')
                      ->orderBy('JP_METADATO_PERSONAL.ENTIDAD_FED_ID','asc')
                      ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxedo',compact('regpersonal','regtotxedo','nombre','usuario','rango'));
    }

    
    // Gráfica por municipio
    public function actionPersonalxMpio(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');  
        $arbol_id     = session()->get('arbol_id');              

        $regtotxmpio=regPersonalModel::join('JP_CAT_MUNICIPIOS_SEDESEM',
                                     [['JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
                                      ['JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','JP_METADATO_PERSONAL.MUNICIPIO_ID']
                                      ])
                         ->selectRaw('COUNT(*) AS TOTALXMPIO')
                               ->get();
        $regpersonal=regPersonalModel::join('JP_CAT_MUNICIPIOS_SEDESEM',
                                      [['JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
                                       ['JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','JP_METADATO_PERSONAL.MUNICIPIO_ID']
                                      ])
                      ->selectRaw('JP_METADATO_PERSONAL.MUNICIPIO_ID, JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE AS MUNICIPIO,COUNT(*) AS TOTAL')
                        ->groupBy('JP_METADATO_PERSONAL.MUNICIPIO_ID', 'JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->orderBy('JP_METADATO_PERSONAL.MUNICIPIO_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.padronxmpio',compact('regpersonal','regtotxmpio','nombre','usuario','rango'));
    }

    // Gráfica por tipo de empleado
    public function actionPersonalxTipoemp(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotales=regPersonalModel::join('JP_CAT_TIPOS_EMPLEADO','JP_CAT_TIPOS_EMPLEADO.TIPOEMP_ID','=',
                                                                   'JP_METADATO_PERSONAL.TIPOEMP_ID')
                    ->selectRaw('COUNT(*) AS TOTAL')
                    ->get();
        $regpersonal =regPersonalModel::join('JP_CAT_TIPOS_EMPLEADO','JP_CAT_TIPOS_EMPLEADO.TIPOEMP_ID','=',
                                                                     'JP_METADATO_PERSONAL.TIPOEMP_ID')
                    ->selectRaw('JP_METADATO_PERSONAL.TIPOEMP_ID, 
                                 JP_CAT_TIPOS_EMPLEADO.TIPOEMP_DESC AS TIPO_EMPLEADO, COUNT(*) AS TOTAL')
                    ->groupBy('JP_METADATO_PERSONAL.TIPOEMP_ID','JP_CAT_TIPOS_EMPLEADO.TIPOEMP_DESC')
                    ->orderBy('JP_METADATO_PERSONAL.TIPOEMP_ID','asc')
                    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxtipoemp',compact('nombre','usuario','rango','regpersonal','regtotales'));
    }

    // Gráfica por clase de empleado
    public function actionPersonalxClaseemp(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotales=regPersonalModel::join('JP_CAT_CLASES_EMPLEADO','JP_CAT_CLASES_EMPLEADO.CLASEEMP_ID','=',
                                                                    'JP_METADATO_PERSONAL.CLASEEMP_ID')
                    ->selectRaw('COUNT(*) AS TOTAL')
                    ->get();
        $regpersonal =regPersonalModel::join('JP_CAT_CLASES_EMPLEADO','JP_CAT_CLASES_EMPLEADO.CLASEEMP_ID','=',
                                                                      'JP_METADATO_PERSONAL.CLASEEMP_ID')
                    ->selectRaw('JP_METADATO_PERSONAL.CLASEEMP_ID, 
                                 JP_CAT_CLASES_EMPLEADO.CLASEEMP_DESC AS CLASE_EMPLEADO, COUNT(*) AS TOTAL')
                    ->groupBy('JP_METADATO_PERSONAL.CLASEEMP_ID','JP_CAT_CLASES_EMPLEADO.CLASEEMP_DESC')
                    ->orderBy('JP_METADATO_PERSONAL.CLASEEMP_ID','asc')
                    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxclaseemp',compact('nombre','usuario','rango','regpersonal','regtotales'));
    }


    // Gráfica por grado de estudios
    public function actionPersonalxEstudios(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotales=regPersonalModel::join('JP_CAT_GRADO_ESTUDIOS','JP_CAT_GRADO_ESTUDIOS.GRADO_ESTUDIOS_ID','=',
                                                                   'JP_METADATO_PERSONAL.GRADO_ESTUDIOS_ID')
                    ->selectRaw('COUNT(*) AS TOTAL')
                    ->get();
        $regpersonal =regPersonalModel::join('JP_CAT_GRADO_ESTUDIOS','JP_CAT_GRADO_ESTUDIOS.GRADO_ESTUDIOS_ID','=',
                                                                     'JP_METADATO_PERSONAL.GRADO_ESTUDIOS_ID')
                    ->selectRaw('JP_METADATO_PERSONAL.GRADO_ESTUDIOS_ID, 
                                 JP_CAT_GRADO_ESTUDIOS.GRADO_ESTUDIOS_DESC AS GRADO_ESTUDIOS, COUNT(*) AS TOTAL')
                    ->groupBy('JP_METADATO_PERSONAL.GRADO_ESTUDIOS_ID','JP_CAT_GRADO_ESTUDIOS.GRADO_ESTUDIOS_DESC')
                    ->orderBy('JP_METADATO_PERSONAL.GRADO_ESTUDIOS_ID','asc')
                    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxestudios',compact('regpersonal','regtotales','nombre','usuario','rango'));
    }

    // Gráfica x sexo
    public function actionPersonalxSexo(){
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
        $regtotal =regPersonalModel::selectRaw('COUNT(*) AS TOTAL')
                   ->get();
        $regpersonal=regPersonalModel::selectRaw('SEXO, COUNT(*) AS TOTAL')
                   ->groupBy('SEXO')
                   ->orderBy('SEXO','asc')
                   ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxsexo',compact('regtotal','regpersonal','nombre','usuario','rango'));
    }   

    // Gráfica x edad
    public function actionPersonalxedad(){
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
        $regtotal =regPersonalModel::selectRaw('COUNT(*) AS TOTAL')
                   ->get();
        //$regpersonal=regPersonalModel::selectRaw('EXTRACT(YEAR FROM SYSDATE) - TO_NUMBER(SUBSTR(FECHA_NACIMIENTO2,7,4)) EDAD,
        //                                      COUNT(1) AS TOTAL')
        //           ->groupBy('EXTRACT(YEAR FROM SYSDATE) - TO_NUMBER(SUBSTR(FECHA_NACIMIENTO2,7,4))')
        $regpersonal=regPersonalModel::select('PERIODO_ID2')
                   ->selectRaw('EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2 EDAD,
                                COUNT(1) AS TOTAL')
                   ->groupBy('PERIODO_ID2')                   
                   ->orderBy('TOTAL','asc')
                   ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxedad',compact('regtotal','regpersonal','nombre','usuario','rango'));
    }   

    // Gráfica x rango de edad
    public function actionPersonalxRangoedad(){
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
        $regtotal =regPersonalModel::selectRaw('COUNT(*) AS TOTAL')
                   ->get();
        $regpersonal=regPersonalModel::select('PERIODO_ID')
                   ->selectRaw('SUM(CASE WHEN (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) <= 5                               THEN 1 ELSE 0 END) EMENOSDE5')  
                   ->selectRaw('SUM(CASE WHEN (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) >= 6 AND (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) <=10 THEN 1 ELSE 0 END) E06A10')
                   ->selectRaw('SUM(CASE WHEN (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) >=11 AND (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) <=17 THEN 1 ELSE 0 END) E11A17')
                   ->selectRaw('SUM(CASE WHEN (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) >=18 AND (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) <=30 THEN 1 ELSE 0 END) E18A30')
                   ->selectRaw('SUM(CASE WHEN (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) >=31 AND (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) <=60 THEN 1 ELSE 0 END) E31A60')
                   ->selectRaw('SUM(CASE WHEN (EXTRACT(YEAR FROM SYSDATE) - PERIODO_ID2) >=61                                                    THEN 1 ELSE 0 END) E61YMAS')
                    ->selectRaw('COUNT(*) AS TOTAL')
                    ->groupBy('PERIODO_ID')
                    ->orderBy('PERIODO_ID','asc')
                    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.personalxrangoedad',compact('regtotal','regpersonal','nombre','usuario','rango'));
    }        

}
