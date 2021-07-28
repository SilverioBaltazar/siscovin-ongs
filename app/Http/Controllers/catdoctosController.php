<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\catdoctoRequest;
//use App\Http\Requests\iapsjuridicoRequest;
use App\regBitacoraModel;
use App\dependenciasModel;
use App\regPerModel;
use App\regRubroModel;
use App\regFormatosModel;
use App\regDoctosModel;

// Exportar a excel 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportCatDoctos;
// Exportar a pdf
use PDF;
//use Options;

class catdoctosController extends Controller
{

    public function actionBuscarDocto(Request $request)
    {
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $dep          = dependenciasModel::select('DEPEN_ID','DEPEN_DESC')
                        ->where('DEPEN_ID','like','%211C04%')
                        ->orderBy('DEPEN_ID','DESC')
                        ->get();
        $regformato   = regFormatosModel::select('FORMATO_ID', 'FORMATO_DESC', 'FORMATO_ETIQ', 
                                                 'FORMATO_COMANDO1', 'FORMATO_COMANDO2', 'FORMATO_COMANDO3')
                        ->orderBy('FORMATO_ID','asc')
                        ->get();    
        $regper       = regPerModel::select('PER_ID','PER_DESC','PER_FREC')->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')->orderBy('RUBRO_ID','asc')
                        ->get();                                                                         
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        //**************************************************************//
        $name  = $request->get('name');   
        //$email = $request->get('email');  
        //$bio   = $request->get('bio');    
        $regdocto = regDoctosModel::orderBy('DOC_ID', 'ASC')
                  ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                  //->email($email)         //Metodos personalizados
                  //->bio($bio)             //Metodos personalizados
                  ->paginate(30);
        if($regdocto->count() <= 0){
            toastr()->error('No existen registros.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }            
        return view('sicinar.catalogos.verDoctos', compact('nombre','usuario','dep','regformato', 'regper', 'regrubro','regdocto'));
    }
    

    public function actionVerDoctos(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $dep          = dependenciasModel::select('DEPEN_ID','DEPEN_DESC')
                        ->where('DEPEN_ID','like','%211C04%')
                        ->orderBy('DEPEN_ID','DESC')
                        ->get();
        $regformato   = regFormatosModel::select('FORMATO_ID', 'FORMATO_DESC', 'FORMATO_ETIQ', 
                                                 'FORMATO_COMANDO1', 'FORMATO_COMANDO2', 'FORMATO_COMANDO3')
                        ->orderBy('FORMATO_ID','asc')
                        ->get();    
        $regper       = regPerModel::select('PER_ID','PER_DESC','PER_FREC')->get();
        $regrubro     = regRubroModel::select('RUBRO_ID','RUBRO_DESC')->orderBy('RUBRO_ID','asc')
                        ->get();                                                  
        $regdocto = regDoctosModel::select('DOC_ID','DOC_DESC','DOC_FILE','DOC_OBS','DEPENDENCIA_ID','FORMATO_ID', 
                                           'PER_ID','PER_FREC','RUBRO_ID','DOC_STATUS','DOC_STATUS2','DOC_STATUS3',
                                           'FECREG')
                    ->orderBy('DOC_ID','ASC')
                    ->paginate(30);
        if($regdocto->count() <= 0){
            toastr()->error('No existen registros de documentos dados de alta.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.catalogos.verDoctos',compact('nombre','usuario','dep','regformato', 'regper', 'regrubro','regdocto'));

    }

    public function actionNuevoDocto(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $dep         = dependenciasModel::select('DEPEN_ID','DEPEN_DESC')
                       ->where('DEPEN_ID','like','%211C04%')
                       ->orderBy('DEPEN_ID','DESC')
                       ->get();
        $regformato  = regFormatosModel::select('FORMATO_ID', 'FORMATO_DESC', 'FORMATO_ETIQ', 
                                                 'FORMATO_COMANDO1', 'FORMATO_COMANDO2', 'FORMATO_COMANDO3')
                       ->orderBy('FORMATO_ID','asc')
                       ->get();    
        $regper      = regPerModel::select('PER_ID','PER_DESC','PER_FREC')->get();
        $regrubro    = regRubroModel::select('RUBRO_ID','RUBRO_DESC')->orderBy('RUBRO_ID','asc')
                       ->get();                                                  
        $regdocto    = regDoctosModel::select('DOC_ID','DOC_DESC','DOC_FILE','DOC_OBS','DEPENDENCIA_ID','FORMATO_ID', 
                                              'PER_ID','PER_FREC','RUBRO_ID','DOC_STATUS','DOC_STATUS2','DOC_STATUS3',
                                              'FECREG')
                       ->orderBy('DOC_ID','asc')->get();
        //dd($unidades);
        return view('sicinar.catalogos.nuevoDocto',compact('regdocto','regrubro','regper','regformato','dep','nombre','usuario','id_estructura'));
    }

    public function actionAltaNuevoDocto(Request $request){
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
        $per_frec= regPerModel::ObtFrec($request->per_id);

        $doc_id  = regDoctosModel::max('DOC_ID');
        $doc_id  = $doc_id+1;

        $nuevodocto = new regDoctosModel();
        $name1 =null;

        //Comprobar  si el campo de archivo tiene un archivo asignado:
        if($request->hasFile('doc_file')){
           $name1 = $doc_id.'_'.$request->file('doc_file')->getClientOriginalName(); 
           //$file->move(public_path().'/images/', $name1);
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('doc_file')->move(public_path().'/images/', $name1);
        }

        $nuevodocto->DOC_ID      = $doc_id;
        $nuevodocto->DOC_DESC    = strtoupper($request->doc_desc);
        $nuevodocto->DOC_OBS     = strtoupper($request->doc_obs);
        $nuevodocto->DEPENDENCIA_ID = $request->dependencia_id;
        $nuevodocto->PER_ID      = $request->per_id;
        $nuevodocto->PER_FREC    = $per_frec[0]->per_frec;
        $nuevodocto->FORMATO_ID  = $request->formato_id;
        $nuevodocto->DOC_STATUS2 = $request->doc_status2;
        $nuevodocto->DOC_STATUS3 = $request->doc_status3;
        $nuevodocto->RUBRO_ID    = $request->rubro_id;

        $nuevodocto->DOC_FILE    = $name1;
        $nuevodocto->IP          = $ip;
        $nuevodocto->LOGIN       = $nombre;         // Usuario ;
        $nuevodocto->save();

        if($nuevodocto->save() == true){
            toastr()->success('Documento dado de alta..','ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         6;
            $xfuncion_id  =      6011;
            $xtrx_id      =       175;    //Alta 

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                          'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $doc_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $doc_id;         // Folio    
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
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $doc_id])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $doc_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP           = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/ 

            //return redirect()->route('nuevoDocto');
            //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','rango','preguntas','apartados'));
        }else{
            toastr()->error('Error inesperado al dar de alta el docto. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            //return back();
            //return redirect()->route('nuevoDocto');
        }

        return redirect()->route('verDoctos');
    }

public function actionEditarDocto($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

        $dep         = dependenciasModel::select('DEPEN_ID','DEPEN_DESC')
                       ->where('DEPEN_ID','like','%211C04%')
                       ->orderBy('DEPEN_ID','DESC')
                       ->get();
        $regformato  = regFormatosModel::select('FORMATO_ID', 'FORMATO_DESC', 'FORMATO_ETIQ', 
                                                 'FORMATO_COMANDO1', 'FORMATO_COMANDO2', 'FORMATO_COMANDO3')
                       ->orderBy('FORMATO_ID','asc')
                       ->get();    
        $regper      = regPerModel::select('PER_ID','PER_DESC','PER_FREC')->get();
        $regrubro    = regRubroModel::select('RUBRO_ID','RUBRO_DESC')->orderBy('RUBRO_ID','asc')
                       ->get();                                                  
        $regdocto    = regDoctosModel::select('DOC_ID','DOC_DESC','DOC_FILE','DOC_OBS','DEPENDENCIA_ID','FORMATO_ID', 
                                              'PER_ID','PER_FREC','RUBRO_ID','DOC_STATUS','DOC_STATUS2','DOC_STATUS3',
                                              'FECREG')
                       ->where('DOC_ID',$id)
                       ->orderBy('DOC_ID','ASC')
                       ->first();
        if($regdocto->count() <= 0){
            toastr()->error('No existe registros de documentos.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('nuevaIap');
        }
        return view('sicinar.catalogos.editarDocto',compact('nombre','usuario','dep','regformato','regper','regrubro','regdocto'));

    }

    public function actionActualizarDocto(catdoctoRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');

        // **************** actualizar ******************************
        $per_frec= regPerModel::ObtFrec($request->per_id);

        $regdocto = regDoctosModel::where('DOC_ID',$id);
        if($regdocto->count() <= 0)
            toastr()->error('No existe documento.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $name1 =null;
            //   if(!empty($_PUT['iap_foto1'])){
            if(isset($request->doc_file)){
                if(!empty($request->doc_file)){
                    //Comprobar  si el campo foto1 tiene un archivo asignado:
                    if($request->hasFile('doc_file')){
                      $name1 = $id.'_'.$request->file('doc_file')->getClientOriginalName(); 
                      //sube el archivo a la carpeta del servidor public/images/
                      $request->file('doc_file')->move(public_path().'/images/', $name1);
                    }
                }
            }

            $regdocto = regDoctosModel::where('DOC_ID',$id)        
            ->update([                
                'DOC_DESC'      => strtoupper($request->doc_desc),
                'DOC_OBS'       => strtoupper($request->doc_obs),
                'DEPENDENCIA_ID'=> $request->dependencia_id,
                'FORMATO_ID'    => $request->formato_id,                
                'PER_ID'        => $request->per_id,
                'PER_FREC'      => $per_frec[0]->per_frec,
                'RUBRO_ID'      => $request->rubro_id,

                'DOC_STATUS'    => $request->doc_status,                
                'DOC_STATUS2'   => $request->doc_status2,
                'DOC_STATUS3'   => $request->doc_status3,                                
                'IP_M'          => $ip,
                'LOGIN_M'       => $nombre,
                'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')                                
            ]);
            toastr()->success('Documento actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         6;
            $xfuncion_id  =      6011;
            $xtrx_id      =       176;    //Actualizar        

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
            }   /************ Bitacora termina *************************************/                     
        }       /************ Registra docto. **************************************/

        return redirect()->route('verDoctos');
    }

    public function actionBorrarDocto($id){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        /************ Eliminar registro ************************************/
        $regdocto    = regDoctosModel::select('DOC_ID','DOC_DESC','DOC_FILE','DOC_OBS','DEPENDENCIA_ID','FORMATO_ID', 
                                              'PER_ID','PER_FREC','RUBRO_ID','DOC_STATUS','DOC_STATUS2','DOC_STATUS3',
                                              'FECREG')
                       ->where('DOC_ID',$id);
        if($regdocto->count() <= 0)
            toastr()->error('No existe el documento.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdocto->delete();
            toastr()->success('Documento eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        
            //echo 'Ya entre aboorar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         6;
            $xfuncion_id  =      6011;
            $xtrx_id      =       177;     // Baja 
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
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar  *************************/

        return redirect()->route('verDoctos');
    }    

    // exportar a formato catalogo de doctos a formato excel
    public function exportCatDoctosExcel(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $estructura   = session()->get('estructura');
        $id_estruc    = session()->get('id_estructura');
        $id_estructura= rtrim($id_estruc," ");
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        
        /************ Bitacora inicia *************************************/ 
        setlocale(LC_TIME, "spanish");        
        $xip          = session()->get('ip');
        $xperiodo_id  = (int)date('Y');
        $xprograma_id = 1;
        $xmes_id      = (int)date('m');
        $xproceso_id  =         6;
        $xfuncion_id  =      6009;
        $xtrx_id      =       178;            // Exportar a formato Excel
        $id           =         0;
        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                                                'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 
                                                'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
            $nuevoregBitacora->IP         = $xip;            // IP
            $nuevoregBitacora->LOGIN      = $nombre;        // Usuario 

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
                'IP_M' => $regbitacora->IP           = $xip,
                'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
            ]);
            toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }
        /************ Bitacora termina *************************************/  

        return Excel::download(new ExcelExportCatDoctos, 'Cat_Documentos_'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato catalogo de doctos a formato PDF
    public function exportCatDoctosPdf(){
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

        $dep         = dependenciasModel::select('DEPEN_ID','DEPEN_DESC')
                       ->where('DEPEN_ID','like','%211C04%')
                       ->get();
        $regformato  = regFormatosModel::select('FORMATO_ID', 'FORMATO_DESC', 'FORMATO_ETIQ')
                       ->get();    
        $regper      = regPerModel::select('PER_ID','PER_DESC','PER_FREC')
                       ->get();
        $regrubro    = regRubroModel::select('RUBRO_ID','RUBRO_DESC')->orderBy('RUBRO_ID','asc')
                       ->get();                                                  
        $regdocto    = regDoctosModel::select('DOC_ID','DOC_DESC','DOC_FILE','DOC_OBS','DEPENDENCIA_ID','FORMATO_ID', 
                                              'PER_ID','PER_FREC','RUBRO_ID','DOC_STATUS','DOC_STATUS2','DOC_STATUS3',
                                              'FECREG')
                       ->get();
        if($regrubro->count() <= 0){
            toastr()->error('No existen registros en el catalogo de documentos.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('verDoctos');
        }else{

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         6;
            $xfuncion_id  =      6009;
            $xtrx_id      =       179;       //Exportar a formato PDF
            $id           =         0;
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                           'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                           'FECHA_M', 'IP_M', 'LOGIN_M')
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
                $nuevoregBitacora->IP         = $xip;            // IP
                $nuevoregBitacora->LOGIN      = $nombre;        // Usuario 
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
                                         'IP_M' => $regbitacora->IP           = $xip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/          

            $pdf = PDF::loadView('sicinar.pdf.catdoctosPDF', compact('nombre','usuario','regdocto','regper','regformato','regrubro','dep'));
            //******** Horizontal ***************
            //$pdf->setPaper('A4', 'landscape');      
            //******** vertical *************** 
            //El tamaño de hoja se especifica en page_size puede ser letter, legal, A4, etc.         
            $pdf->setPaper('letter','portrait');         
            return $pdf->stream('CatalogoDeDocumentos');
        }   /*********** Termina el if ***********************/
    }

}
