<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\progdilRequest;
use App\Http\Requests\filtro01Request;

use App\regBitacoraModel;
use App\regIapModel;
use App\regPerModel;
use App\regMesesModel;
use App\regDiasModel;
use App\regHorasModel;
use App\regPfiscalesModel;
use App\regMunicipioModel;
use App\regEntidadesModel;

//use App\regRubroModel;
//use App\regFormatosModel;
use App\regDoctosModel;

use App\regAgendaModel;

// Exportar a excel 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportProgramavisitas;
use App\Exports\BladeExport;
// Exportar a pdf
use PDF;
//use Options;

class progdilController extends Controller
{

    public function actionBuscarProgdil(Request $request)
    {
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//
        //**************************************************************//
        $fper  = $request->get('fper');   
        $fmes  = $request->get('fmes');  
        $fdia  = $request->get('fdia');    
        $fiap  = $request->get('fiap');            
        $regprogdil = regAgendaModel::orderBy('VISITA_FOLIO', 'ASC')
                      ->fper($fper)    //Metodos personalizados es equivalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                      ->fmes($fmes)    //Metodos personalizados
                      //->fdia($fdia)    //Metodos personalizados
                      ->fiap($fiap)    //Metodos personalizados
                      ->paginate(50);
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros programados en la agenda.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }            
        return view('sicinar.agenda.verProgdil', compact('nombre','usuario','regiap','regperiodos', 'regdias', 'reghoras','regmeses','regprogdil','regentidades','regmunicipio'));
    }


    public function actionVerProgdil(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                        ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();    
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID',
                                             'MUNICIPIO_ID','ENTIDAD_ID',
                                             'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
                                             'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
                                             'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO','VISITA_OBS2','VISITA_OBS3',
                                             'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('VISITA_FOLIO','ASC')                    
                        ->paginate(30);
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros de programación de visistas de diligencias.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.agenda.verprogdil',compact('nombre','usuario','regmeses', 'reghoras','regdias','regperiodos','regiap','regprogdil','regentidades','regmunicipio'));

    }

public function actionNuevoProgdil(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID', 
                                             'MUNICIPIO_ID','ENTIDAD_ID',
                                             'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
                                             'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
                                             'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO','VISITA_OBS2','VISITA_OBS3',
                                             'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')->orderBy('VISITA_FOLIO','asc')
                        ->get();
        //dd($unidades);
        return view('sicinar.agenda.nuevoProgdil',compact('nombre','usuario','regmeses','reghoras','regdias','regperiodos','regiap','regprogdil','regmunicipio','regentidades'));
    }

    public function actionAltaNuevoProgdil(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

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

        /************ Alta *****************************/ 
        $mes = regMesesModel::ObtMes($request->mes_id);
        $dia = regDiasModel::ObtDia($request->dia_id);

        $visita_folio = regAgendaModel::max('VISITA_FOLIO');
        $visita_folio = $visita_folio+1;

        $nuevoprogdil = new regAgendaModel();

        $nuevoprogdil->VISITA_FOLIO   = $visita_folio;
        $nuevoprogdil->VISITA_OBJ     = substr(strtoupper(trim($request->visita_obj)),0,3999);
        $nuevoprogdil->VISITA_CONTACTO= substr(strtoupper(trim($request->visita_contacto)),0,79);
        $nuevoprogdil->VISITA_TEL     = substr(strtoupper(trim($request->visita_tel)),0,59);
        $nuevoprogdil->VISITA_DOM     = substr(strtoupper(trim($request->visita_dom)),0,79);
        $nuevoprogdil->VISITA_EMAIL   = substr(strtolower(trim($request->visita_email)),0,79);
        $nuevoprogdil->VISITA_SPUB    = substr(strtoupper(trim($request->visita_spub)),0,79);
        $nuevoprogdil->VISITA_SPUB2   = substr(strtoupper(trim($request->visita_spub2)),0,199);
        $nuevoprogdil->VISITA_AUDITOR2= substr(strtoupper(trim($request->visita_auditor2)),0,79);
        $nuevoprogdil->VISITA_AUDITOR4= substr(strtoupper(trim($request->visita_auditor4)),0,79);

        $nuevoprogdil->IAP_ID         = $request->iap_id;
        $nuevoprogdil->PERIODO_ID     = $request->periodo_id;
        $nuevoprogdil->MES_ID         = $request->mes_id;
        $nuevoprogdil->DIA_ID         = $request->dia_id;
        $nuevoprogdil->HORA_ID        = $request->hora_id;
        $nuevoprogdil->ENTIDAD_ID     = $request->entidad_id;
        $nuevoprogdil->MUNICIPIO_ID   = $request->municipio_id;
        $nuevoprogdil->VISITA_TIPO1   = $request->visita_tipo1;

        $nuevoprogdil->VISITA_FECREGP = trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$request->periodo_id);
        $nuevoprogdil->VISITA_OBS3    = substr(strtoupper(trim($request->visita_obs3)),0,3999);

        $nuevoprogdil->IP          = $ip;
        $nuevoprogdil->LOGIN       = $nombre;         // Usuario ;
        $nuevoprogdil->save();

        if($nuevoprogdil->save() == true){
            toastr()->success('Diligencia programada en la agenda correctamente.','OK!',['positionClass' => 'toast-bottom-right']);
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =        3;
            $xfuncion_id  =     3006;
            $xtrx_id      =      180;    //Alta 
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                                    'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 
                                                    'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id,
                                     'FOLIO' => $visita_folio])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $visita_folio;         // Folio    
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
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $visita_folio])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id,
                                        'TRX_ID' => $xtrx_id,'FOLIO' => $visita_folio])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                           ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/             
            //return redirect()->route('nuevoDocto');
            //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','rango','preguntas','apartados'));
        }else{
            toastr()->error('Error inesperado al dar de alta en la agenda la diligencia. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            //return back();
            //return redirect()->route('nuevoDocto');
        }

        return redirect()->route('verProgdil');
    }

    public function actionEditarProgdil($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID',
                                             'MUNICIPIO_ID','ENTIDAD_ID',
                                             'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
                                             'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
                                             'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO','VISITA_OBS2','VISITA_OBS3',
                                             'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where('VISITA_FOLIO',$id)
                        ->orderBy('PERIODO_ID','ASC')
                        ->orderBy('MES_ID','ASC')
                        ->orderBy('DIA_ID','ASC')
                        ->orderBY('HORA_ID','ASC')
                        ->first();
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros en la agenda.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoProgdil');
        }
        return view('sicinar.agenda.editarProgdil',compact('nombre','usuario','regmeses','reghoras','regdias','regiap','regperiodos','regprogdil','regentidades','regmunicipio'));

    }

    public function actionActualizarProgdil(progdilRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');

        // **************** actualizar ******************************
        $regprogdil   = regAgendaModel::where('VISITA_FOLIO',$id);
        if($regprogdil->count() <= 0)
            toastr()->error('No existe diligencia programada en la agenda.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //                'IAP_GEOREF_LATITUD' => $request->iap_georef_latitud, 
            $mes = regMesesModel::ObtMes($request->mes_id);
            $dia = regDiasModel::ObtDia($request->dia_id);
            $regprogdil   = regAgendaModel::where('VISITA_FOLIO',$id)        
            ->update([                 
                'VISITA_OBJ'     => substr(trim(strtoupper($request->visita_obj)),0,3999),
                'VISITA_DOM'     => substr(trim(strtoupper($request->visita_dom)),0,79),
                'VISITA_CONTACTO'=> substr(trim(strtoupper($request->visita_contacto)),0,79),
                'VISITA_EMAIL'   => substr(trim(strtolower($request->visita_email)),0,79),
                'VISITA_TEL'     => substr(trim(strtoupper($request->visita_tel)),0,59),
                'VISITA_SPUB'    => substr(trim(strtoupper($request->visita_spub)),0,79),
                'VISITA_SPUB2'   => substr(trim(strtoupper($request->visita_spub2)),0,199),
                'VISITA_AUDITOR2'=> substr(trim(strtoupper($request->visita_auditor2)),0,79),
                'VISITA_AUDITOR4'=> substr(trim(strtoupper($request->visita_auditor4)),0,79), 
                'IAP_ID'         => $request->iap_id,                
                'PERIODO_ID'     => $request->periodo_id,
                'MES_ID'         => $request->mes_id,
                'DIA_ID'         => $request->dia_id,
                'HORA_ID'        => $request->hora_id,
                'ENTIDAD_ID'     => $request->entidad_id,
                'MUNICIPIO_ID'   => $request->municipio_id,
                'VISITA_TIPO1'   => $request->visita_tipo1,
                'VISITA_FECREGP' => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$request->periodo_id),
                'VISITA_OBS3'    => substr(trim(strtoupper($request->visita_obs3)),0,3999), 
                
                'VISITA_EDO'     => $request->visita_edo,                
                'IP_M'           => $ip,
                'LOGIN_M'        => $nombre,
                'FECHA_M'        => date('Y/m/d')    //date('d/m/Y')                                
            ]);
            toastr()->success('Diligencia actualizada en la agenda.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =        3;
            $xfuncion_id  =     3006;
            $xtrx_id      =      181;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                           'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                           'FECHA_M', 'IP_M', 'LOGIN_M')
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
        }       /************ Termina de actualizar ********************************/

        return redirect()->route('verProgdil');
    }

    public function actionBorrarProgdil($id){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
            
        /************ Eliminar **************************************/
        $regprogdil = regAgendaModel::select('VISITA_FOLIO')
                      ->where('VISITA_FOLIO',$id);
        if($regprogdil->count() <= 0)
            toastr()->error('No existe diligencia en la agenda.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regprogdil->delete();
            toastr()->success('Diligencia programada en la agenda eliminada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            //echo 'Ya entre aboorar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =        3;
            $xfuncion_id  =     3006;
            $xtrx_id      =      182;     // Baja 
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
                                                'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                        'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                        'IP_M'    => $regbitacora->IP       = $ip,
                                        'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                        'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/             
        }   /************* Termina de eliminar  la IAP **********************************/
        return redirect()->route('verProgdil');
    }    

    // exportar a formato PDF
    public function actionMandamientoPDF($id){
        set_time_limit(0);
        ini_set("memory_limit",-1);
        ini_set('max_execution_time', 0);

        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                        ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();        
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID','IAP_DESC','IAP_REGCONS','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::join('JP_IAPS','JP_IAPS.IAP_ID','=','JP_AGENDA.IAP_ID')
                        ->select('JP_IAPS.IAP_DESC','JP_IAPS.IAP_REGCONS',
                        'JP_AGENDA.VISITA_FOLIO',
                        'JP_AGENDA.PERIODO_ID','JP_AGENDA.MES_ID','JP_AGENDA.DIA_ID','JP_AGENDA.HORA_ID',
                        'JP_AGENDA.IAP_ID','JP_AGENDA.MUNICIPIO_ID','JP_AGENDA.VISITA_CONTACTO',
                        'JP_AGENDA.VISITA_TEL','JP_AGENDA.VISITA_EMAIL','JP_AGENDA.VISITA_DOM',
                        'JP_AGENDA.VISITA_OBJ','JP_AGENDA.VISITA_SPUB','JP_AGENDA.VISITA_SPUB2',
                        'JP_AGENDA.VISITA_AUDITOR2','JP_AGENDA.VISITA_AUDITOR4','JP_AGENDA.VISITA_TIPO1',
                        'JP_AGENDA.VISITA_FECREGP','JP_AGENDA.VISITA_EDO','VISITA_OBS2','VISITA_OBS3')
                        ->where('JP_AGENDA.VISITA_FOLIO',$id)
                        ->get();
        if($regprogdil->count() <= 0){
            toastr()->error('No existen diligencia programada en la agenda.','Uppss!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('verIap');
        }else{
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =        3;
            $xfuncion_id  =     3006;
            $xtrx_id      =       184;     // pdf
            $id           =       $id;
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                                    'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 
                                                    'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
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
                                        'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                        'IP_M'    => $regbitacora->IP       = $ip,
                                        'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                        'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/ 

            /**************** Genera reporte pdf **********************/            
            $pdf = PDF::loadView('sicinar.pdf.mandamientoPDF', compact('nombre','usuario','regmeses','reghoras','regdias','regperiodos','regiap','regprogdil','regentidades','regmunicipio'));
            //$options = new Options();
            //$options->set('defaultFont', 'Courier');
            //$pdf->set_option('defaultFont', 'Courier');
            //******** Horizontal ***************
            //$pdf->setPaper('A4', 'landscape');      
            //$pdf->set('defaultFont', 'Courier');
            //$pdf->set_options('isPhpEnabled', true);
            //$pdf->setOptions(['isPhpEnabled' => true]);
            //******** vertical ***************          
            $pdf->setPaper('A4','portrait');

            // Output the generated PDF to Browser
            return $pdf->stream('Mandamiento');
        }
    }

    public function actionReporteProgvisitas(){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID',
                                             'MUNICIPIO_ID','ENTIDAD_ID',
                                             'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
                                             'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
                                             'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO','VISITA_OBS2','VISITA_OBS3',
                                             'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('PERIODO_ID','ASC')
                        ->orderBy('MES_ID','ASC')
                        ->orderBy('DIA_ID','ASC')
                        ->orderBY('HORA_ID','ASC') 
                        ->first(); 
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros de visitas programadas en la agenda.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoProgdil');
        }
        return view('sicinar.agenda.reporteProgramavisitas',compact('nombre','usuario','regmeses','reghoras','regdias','regiap','regperiodos','regprogdil','regentidades','regmunicipio'));

    }

    // exportar a formato PDF
    public function actionProgramavisitasPdf(filtro01Request $request){
        //dd('tipo 2:',$request->visita_tipo2);
        //if($request->visita_tipo2 == 'E'){
            //dd('hola ya entre......');  
            //return redirect()->route('programavisitasExcel',[$request->periodo_id, $request->mes_id, $request->visita_tipo1]);
            //return view('programavisitasExcel',[$request->periodo_id, $request->mes_id, $request->visita_tipo1]);
        //}else{

        set_time_limit(0);
        ini_set("memory_limit",-1);
        ini_set('max_execution_time', 0);

        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                        ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();        
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID','IAP_DESC','IAP_REGCONS','IAP_RFC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::join('JP_IAPS','JP_IAPS.IAP_ID','=','JP_AGENDA.IAP_ID')
                        ->select('JP_IAPS.IAP_DESC','JP_IAPS.IAP_REGCONS',
                        'JP_AGENDA.VISITA_FOLIO',
                        'JP_AGENDA.PERIODO_ID','JP_AGENDA.MES_ID','JP_AGENDA.DIA_ID','JP_AGENDA.HORA_ID',
                        'JP_AGENDA.IAP_ID','JP_AGENDA.MUNICIPIO_ID','JP_AGENDA.VISITA_CONTACTO',
                        'JP_AGENDA.VISITA_TEL','JP_AGENDA.VISITA_EMAIL','JP_AGENDA.VISITA_DOM',
                        'JP_AGENDA.VISITA_OBJ','JP_AGENDA.VISITA_SPUB','JP_AGENDA.VISITA_SPUB2',
                        'JP_AGENDA.VISITA_AUDITOR2','JP_AGENDA.VISITA_AUDITOR4','JP_AGENDA.VISITA_TIPO1',
                        'JP_AGENDA.VISITA_FECREGP','JP_AGENDA.VISITA_EDO','VISITA_OBS2','VISITA_OBS3')
                        ->where( ['JP_AGENDA.PERIODO_ID'   => $request->periodo_id, 
                                  'JP_AGENDA.MES_ID'       => $request->mes_id,
                                  'JP_AGENDA.VISITA_TIPO1' => $request->visita_tipo1])
                        ->orderBy('JP_AGENDA.PERIODO_ID','ASC')
                        ->orderBy('JP_AGENDA.VISITA_FOLIO','ASC')
                        ->get();
        if($regprogdil->count() <= 0){
            toastr()->error('No existe visitas proramadas en la agenda.','Uppss!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('verIap');
        }else{
            /************ Bitacora inicia *************************************/ 
            $id           =        1;
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3006;
            $xtrx_id      =       184;     // pdf
            $id           =       $id;
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                                    'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 
                                                    'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
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
                                        'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                        'IP_M'    => $regbitacora->IP       = $ip,
                                        'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                        'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/ 

            /**************** Genera reporte pdf **********************/            
            $pdf = PDF::loadView('sicinar.pdf.programavisitasPdf', compact('nombre','usuario','regmeses','reghoras','regdias','regperiodos','regiap','regprogdil','regentidades','regmunicipio'));
            //$options = new Options();
            //$options->set('defaultFont', 'Courier');
            //$pdf->set_option('defaultFont', 'Courier');
            //******** Horizontal ***************
            $pdf->setPaper('A4', 'landscape');      
            //$pdf->set('defaultFont', 'Courier');
            //$pdf->set_options('isPhpEnabled', true);
            //$pdf->setOptions(['isPhpEnabled' => true]);
            //******** vertical ***************          
            //$pdf->setPaper('A4','portrait');

            // Output the generated PDF to Browser
            return $pdf->stream('ProgramaDeVisitas');
        }   //*************** Genera reporte en formato PDF **************************//

        //}   //******** Termina la selección del tipo de reporte *********************//
    }


    public function actionReporteProgvisitasExcel(){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')
                           ->orderBy('ENTIDADFEDERATIVA_ID','asc')
                           ->get();
        $regmunicipio = regMunicipioModel::join('JP_CAT_ENTIDADES_FED','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 'JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID')
                        ->select('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','JP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->wherein('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','DESC')
                        ->orderBy('JP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE','DESC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();   
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        //$regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID',
        //                                     'MUNICIPIO_ID','ENTIDAD_ID',
        //                                     'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
        //                                     'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
        //                                     'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO','VISITA_OBS2','VISITA_OBS3',
        //                                     'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
        //                ->orderBy('PERIODO_ID','ASC')
        //                ->orderBy('MES_ID','ASC')
        //                ->orderBy('DIA_ID','ASC')
        //                ->orderBY('HORA_ID','ASC')
        $regprogdil   =regAgendaModel::join('JP_CAT_HORAS','JP_CAT_HORAS.HORA_ID','=','JP_AGENDA.HORA_ID')
                              ->join('JP_IAPS'     ,'JP_IAPS.IAP_ID'      ,'=','JP_AGENDA.IAP_ID')
                            ->select('JP_AGENDA.PERIODO_ID',
                                     'JP_AGENDA.MES_ID','JP_AGENDA.DIA_ID',
                                     'JP_AGENDA.VISITA_FOLIO',
                                     'JP_AGENDA.IAP_ID', 'JP_IAPS.IAP_DESC',
                                     'JP_IAPS.IAP_REGCONS','JP_IAPS.IAP_RFC',
                                     'JP_AGENDA.VISITA_DOM',
                                     'JP_AGENDA.ENTIDAD_ID','JP_AGENDA.MUNICIPIO_ID',
                                     'JP_AGENDA.VISITA_FECREGP',
                                     'JP_CAT_HORAS.HORA_DESC',
                                     'JP_AGENDA.VISITA_CONTACTO',                         
                                     'JP_AGENDA.VISITA_OBJ','VISITA_OBS3',
                                     'JP_AGENDA.VISITA_TIPO1'
                                     )
                            //->where( ['JP_AGENDA.PERIODO_ID'   => $id, 
                            //          'JP_AGENDA.MES_ID'       => $id1,
                            //          'JP_AGENDA.VISITA_TIPO1' => $id2])
                            ->orderBy('JP_AGENDA.PERIODO_ID','ASC')
                            ->orderBy('JP_AGENDA.VISITA_FOLIO','ASC')    
                            ->get();
                            //->toArray();
                        //->first();
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros de visitas programadas en la agenda.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoProgdil');
        }
        return view('sicinar.agenda.reporteProgramavisitasExcel',compact('nombre','usuario','regmeses','reghoras','regdias','regiap','regperiodos','regprogdil','regentidades','regmunicipio'));

    }

    

     //Exportar a formato excel
    public function actionProgramavisitasExcel(filtro01Request $request){
        //dd('id..............',$id,'-id1:',$id1,'-id2:',$id2);
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3006;
            $xtrx_id      =       183;     // excel
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
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                            

        
        //$regprogdil = regAgendaModel::where( ['PERIODO_ID'   => $request->periodo_id, 
        //                                      'MES_ID'       => $request->mes_id,
        //                                      'VISITA_TIPO1' => $request->visita_tipo1])
        //              ->get();
                      //->toArray();
                      //dd($regprogdil->count(),'periodo:',$request->periodo_id,' mes:',$request->mes_id,'tipo:',$request->visita_tipo1);
        //if($regprogdil->count() <= 0)
        //    toastr()->error('No hay registros del programa de visitas en la agenda.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        //else{

            return Excel::download(new ExcelExportProgramavisitas($request->periodo_id,$request->mes_id,$request->visita_tipo1),'ProgramaVisitas_'.date('d-m-Y').'.xlsx');
        //}
    }    

    //Exportar a formato excel
    public function actionProgramavisitasExcel222(filtro01Request $request){
        //dd('id..............',$id,'-id1:',$id1,'-id2:',$id2);
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3006;
            $xtrx_id      =       183;     // excel
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
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                            

       
                      //->toArray()
                      //->get()->toArray(); 
        $student_array[] = array('PERIODO_FISCAL','MES'      ,'DIA'    ,'FOLIO'    ,'ID_IAP','IAP','REG_CONSTITUCION',
                                 'RFC'           ,'DOMICILIO','ENTIDAD','MUNICIPIO','FECHA_VISITA','HORA',
                                 'CONTACTO'      ,'OBJETO_VISITA_PARTE_1','OBJETO_VISITA_PARTE_2');
        //$student_data = DB::table('student_details')->get()->toArray();
        $regprogdil = regAgendaModel::where( ['PERIODO_ID'   => $request->periodo_id, 
                                               'MES_ID'       => $request->mes_id,
                                               'VISITA_TIPO1' => $request->visita_tipo1])
                      ->get();
                      //->toArray();
        if($regprogdil->count() <= 0)
            toastr()->error('No registro del programa de visitas en la agenda.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{
            //dd($regprogdil);
            foreach($regprogdil as $student)
            {
                $student_array[]  =  array(
                'PERIODO_ID'      => $student->periodo_id,
                'MES_ID'          => $student->mes_id,
                'DIA_ID'          => $student->dia_id,
                'VISITA_FOLIO'    => $student->visita_folio,
                'IAP_ID'          => $student->iap_id,
                'IAP_DESC'        => $student->iap_desc,  

                'IAP_REGCONS'     => $student->iap_regcons,
                'IAP_RFC'         => $student->iap_rfc,
                'VISITA_DOM'      => $student->visita_dom,
                'ENTIDAD_ID'      => $student->entidad_id,
                'MUNICIPIO_ID'    => $student->municipio_id,  

                'VISITA_FECREGP'  => $student->visita_fecregp,
                'HORA_DESC'       => $student->hora_desc,
                'VISITA_CONTACTO' => $student->visita_contacto,              
                'VISITA_OBJ'      => $student->visita_obj,
                'VISITA_OBS3'     => $student->visita_obs3
                );
            }
            //dd($regprogdil);
            //Excel::download('ProgramaVisitas', function($excel) use ($student_array)
            //{
                //dd('hola...',$regprogdil);
                //$excel->setTitle('ProgramaVisitas_'.date('d-m-Y'));
                //$excel->sheet('Student_Datass', function($sheet) use ($student_array)
                //{
                //    $sheet->fromArray($student_array, null, 'A1', false, false);
                //});
            //})->download('xlsx');

        }                        
        //return Excel::download(new BladeExport($student_array),'ProgramaVisitas_'.date('d-m-Y').'.xlsx');
        return Excel::download(new BladeExport($regprogdil),'ProgramaVisitas_'.date('d-m-Y').'.xlsx');
    }   


    public function actionVerProgdilGraficaxmes(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $reghoras     = regHorasModel::select('HORA_ID','HORA_DESC')->get();    
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID',
                                             'MUNICIPIO_ID','ENTIDAD_ID',
                                             'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
                                             'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
                                             'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO','VISITA_OBS2','VISITA_OBS3',
                                             'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('VISITA_FOLIO','ASC')                    
                        ->paginate(30);
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros de programación de visistas de diligencias.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.agenda.verProgdilGraficaxmes',compact('nombre','usuario','regmeses', 'reghoras','regdias','regperiodos','regiap','regprogdil'));

    }

    // Gráfica programa de diligencias x mes
    public function actionProgdilGraficaxmes(Request $request){
        $nombre      = session()->get('userlog');
        $pass        = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario     = session()->get('usuario');
        $rango       = session()->get('rango');
        $ip          = session()->get('ip'); 
        $arbol_id    = session()->get('arbol_id');               

        $regperiodos = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')
                       ->where('PERIODO_ID',$request->periodo_id)
                       ->get();        
        $agendatotxmes=regAgendaModel::join('JP_CAT_MESES','JP_CAT_MESES.MES_ID','=','JP_AGENDA.MES_ID')
                       ->selectRaw('COUNT(*) AS TOTALXMES')
                       ->get();                        
        $regprogdil  = regAgendaModel::join('JP_CAT_MESES','JP_CAT_MESES.MES_ID','=','JP_AGENDA.MES_ID')
                       ->selectRaw('JP_AGENDA.MES_ID,  JP_CAT_MESES.MES_DESC AS MES, COUNT(*) AS TOTAL')
                       ->where(  'PERIODO_ID',$request->periodo_id)
                       ->groupBy('JP_AGENDA.MES_ID','JP_CAT_MESES.MES_DESC')
                       ->orderBy('JP_AGENDA.MES_ID','asc')
                       ->get();                       
        //dd('Valor:'.$request->periodo_id,$regprogdil);
        return view('sicinar.numeralia.progdilgraficaxmes',compact('nombre','usuario','rango','regperiodos','regprogdil','agendatotxmes'));
    }

    public function actionVerProgdilGraficaxtipo(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->get();       
        $regprogdil   = regAgendaModel::select('VISITA_FOLIO','PERIODO_ID','MES_ID','DIA_ID','HORA_ID','IAP_ID',
                                             'MUNICIPIO_ID','ENTIDAD_ID',
                                             'VISITA_CONTACTO','VISITA_TEL','VISITA_EMAIL','VISITA_DOM','VISITA_OBJ',
                                             'VISITA_SPUB','VISITA_SPUB2','VISITA_AUDITOR2','VISITA_AUDITOR4',
                                             'VISITA_TIPO1','VISITA_FECREGP','VISITA_EDO')
                        ->orderBy('VISITA_FOLIO','ASC')                    
                        ->paginate(30);
        if($regprogdil->count() <= 0){
            toastr()->error('No existen registros de programación de visistas de diligencias.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.agenda.verProgdilGraficaxtipo',compact('nombre','usuario','regmeses', 'regperiodos','regiap','regprogdil'));

    }

    // Gráfica programa de diligencias x tipo
    public function actionProgdilGraficaxtipo(Request $request){
        $nombre      = session()->get('userlog');
        $pass        = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario     = session()->get('usuario');
        $rango       = session()->get('rango');
        $ip          = session()->get('ip'); 
        $arbol_id    = session()->get('arbol_id');               

        $regmeses    = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $regperiodos = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')
                       ->where('PERIODO_ID',$request->periodo_id)
                       ->get();        
        $agendatotxtipo=regAgendaModel::selectRaw('COUNT(*) AS TOTALXTIPO')
                       ->get();                        
        $regprogdil  = regAgendaModel::selectRaw('VISITA_TIPO1, COUNT(*) AS TOTAL')
                       ->where(  'PERIODO_ID',$request->periodo_id)
                       ->groupBy('VISITA_TIPO1')
                       ->orderBy('VISITA_TIPO1','asc')
                       ->get();                       
        //dd('Valor:'.$request->periodo_id,$regprogdil);
        return view('sicinar.numeralia.progdilgraficaxtipo',compact('nombre','usuario','rango','regperiodos','regprogdil','agendatotxtipo'));
    }

}
