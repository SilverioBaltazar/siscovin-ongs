<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\catdocto1Request;

use App\regBitacoraModel;
use App\dependenciasModel;
use App\regPerModel;
use App\regRubroModel;
use App\regFormatosModel;
use App\regDoctosModel;
// Exportar a excel 
//use App\Exports\ExcelExportCatIAPS;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class catdoctosController1 extends Controller
{



    public function actionEditarDocto1($id){
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
        $regper      = regPerModel::select('PER_ID', 'PER_DESC')->get();
        $regrubro    = regRubroModel::select('RUBRO_ID','RUBRO_DESC')->orderBy('RUBRO_ID','asc')
                       ->get();                                                  
        $regdocto    = regDoctosModel::select('DOC_ID', 'DOC_DESC', 'DOC_FILE', 'DOC_OBS', 'DEPENDENCIA_ID', 'FORMATO_ID', 
                                           'PER_ID', 'RUBRO_ID', 'DOC_STATUS', 'FECREG')
                       ->where('DOC_ID',$id)
                       ->orderBy('DOC_ID','ASC')
                       ->first();
        if($regdocto->count() <= 0){
            toastr()->error('No existe registros de documentos.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('nuevaIap');
        }
        return view('sicinar.catalogos.editarDocto1',compact('nombre','usuario','estructura','id_estructura','dep','regformato','regper','regrubro','regdocto'));

    }

    public function actionActualizarDocto1(catdocto1Request $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');  

        // **************** actualizar ******************************
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

                        $regdocto = regDoctosModel::where('DOC_ID',$id)        
                                    ->update([                
                                              'DOC_DESC'  => $request->doc_desc,                
                                              'DOC_FILE'  => $name1,
                        
                                              'IP_M'      => $ip,
                                              'LOGIN_M'   => $nombre,
                                              'FECHA_M'   => date('Y/m/d') //date('d/m/Y')                                
                                              ]);
                        toastr()->success('Archivo de documento digital actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

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
                    }
                }
            }

        }       /************ Actualiza documento **********************************/

        return redirect()->route('verDoctos');
    }


}
