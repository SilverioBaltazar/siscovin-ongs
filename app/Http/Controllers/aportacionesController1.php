<?php
//**************************************************************/
//* File:       aportacionesController.php
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: diciembre 2019
//* @Derechos reservados. Gobierno del Estado de México
//*************************************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\aportaciones1Request;
use App\Http\Requests\iapsjuridicoRequest;
use App\regIapModel;
use App\regIapJuridicoModel;
use App\regBitacoraModel;
use App\MunicipioModel;
use App\regRubroModel;
use App\regEntidadesModel;
use App\regBancosModel;
use App\regMesesModel;
use App\regPfiscalesModel;
//use APP\regPeriodossModel;
use App\regAportacionesModel;
// Exportar a excel 
use App\Exports\ExcelExportCatIAPS;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class aportacionesController1 extends Controller
{

    /****************** Editar comprobante de registro de aportación monetaria **********/
    public function actionEditarApor1($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');

        $regbancos  = regBancosModel::select('BANCO_ID', 'BANCO_DESC')->orderBy('BANCO_DESC','asc')
                      ->get();
        $regmeses   = regMesesModel::select('MES_ID', 'MES_DESC')->orderBy('MES_ID','asc')
                      ->get();
        $regperiodos= regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                      ->get();        
        $regiap     = regIapModel::select('IAP_ID', 'IAP_DESC', 'IAP_CALLE','IAP_NUM','IAP_COLONIA','IAP_STATUS')
                      ->orderBy('IAP_DESC','asc')
                      ->get();
        $regapor    = regAportacionesModel::select('APOR_FOLIO','PERIODO_ID','IAP_ID','MES_ID','BANCO_ID',
                      'APOR_NOCHEQUE','APOR_CONCEPTO','APOR_MONTO','APOR_ENTREGA','APOR_RECIBE','APOR_COMPDEPO',
                      'APOR_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                      ->where('APOR_FOLIO',$id)
                      ->first();
        if($regapor->count() <= 0){
            toastr()->error('No existe registro de aportación monetaria.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('nuevaApor');
        }
        return view('sicinar.aportaciones.editarApor1',compact('nombre','usuario','estructura','id_estructura','regiap','regbancos','regmeses','regperiodos', 'regapor'));

    }

    public function actionActualizarApor1(aportaciones1Request $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');

        // **************** actualizar ******************************
        $regapor = regAportacionesModel::where('APOR_FOLIO',$id);
        if($regapor->count() <= 0)
            toastr()->error('No existe folio de la aportacion monetaria.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{

            $name02 =null;
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('apor_compdepo')){
                echo "Escribió en el campo de texto 1: " .'-'. $request->apor_compdepo .'-'. "<br><br>"; 
                $name02 = $id.'_'.$request->file('apor_compdepo')->getClientOriginalName(); 
                //sube el archivo a la carpeta del servidor public/images/
                $request->file('apor_compdepo')->move(public_path().'/images/', $name02);

                $regapor = regAportacionesModel::where('APOR_FOLIO',$id)        
                           ->update([                
                    'APOR_COMPDEPO'=> $name02,
                    'IP_M'         => $ip,
                    'LOGIN_M'      => $nombre,
                    'FECHA_M'      => date('Y/m/d')    //date('d/m/Y')                                
                ]);
                toastr()->success('Archivo de comprobante de depósito de caja actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         4;
                $xfuncion_id  =      4003;
                $xtrx_id      =       156;    //Actualizar aportacion monetaria        
                $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                           'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 
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
                        toastr()->success('Bitacora dada de alta.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error inesperado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
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
        return redirect()->route('verApor');
        //return view('sicinar.catalogos.verProceso',compact('nombre','usuario','estructura','id_estructura','regproceso'));
    }

}
