<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\iaps1Request;

use App\regIapModel;
use App\regBitacoraModel;

// Exportar a excel 
//use App\Exports\ExcelExportCatIAPS;
//use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
//use PDF;
//use Options;

class iapsController1 extends Controller
{
  

    public function actionEditarIap1($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

        $regiap = regIapModel::select('IAP_ID','IAP_DESC','IAP_STATUS','IAP_FOTO1','IAP_FOTO2')->where('IAP_ID',$id)
                  ->orderBy('IAP_ID','ASC')
                  ->first();
        if($regiap->count() <= 0){
            toastr()->error('No existen ONGS.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.iaps.editarIap1',compact('nombre','usuario','regiap'));

    }

    public function actionActualizarIap1(iaps1Request $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');

        // **************** actualizar ******************************
        $regiap = regIapModel::where('IAP_ID',$id);
        if($regiap->count() <= 0)
            toastr()->error('No existe ONG.' ,'¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //                'IAP_GEOREF_LATITUD' => $request->iap_georef_latitud, 
            //    'IAP_GEOREF_LONGITUD'=> $request->iap_georef_longitud, 
            //    'IAP_FOTO1'   => $request->iap_foto1, 
            //    'IAP_FOTO2'   => $request->iap_foto2,
            $name01 =null;
            //echo "Escribió en el campo de texto 1: " .'-'. $request->iap_d01 .'-'. "<br><br>"; 
            //echo "Escribió en el campo de texto 1: " . $request->iap_d01 . "<br><br>"; 
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('iap_foto1')){
                echo "Escribió en el campo de texto 3: " .'-'. $request->iap_foto1 .'-'. "<br><br>"; 
                $name01 = $id.'_'.$request->file('iap_foto1')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('iap_foto1')->move(public_path().'/images/', $name01);

                $regiap = regIapModel::where('IAP_ID',$id)        
                          ->update([                
                                    'IAP_FOTO1' => $name01,

                                    'IP_M'      => $ip,
                                    'LOGIN_M'   => $nombre,
                                    'FECHA_M'   => date('Y/m/d')    //date('d/m/Y')                                
                                    ]);
                toastr()->success('Fotografía 1 actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =       146;    //Actualizar 
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
                                         'IP_M'     => $regbitacora->IP           = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/         

            }            
        }
        return redirect()->route('verIap');
    }

}
