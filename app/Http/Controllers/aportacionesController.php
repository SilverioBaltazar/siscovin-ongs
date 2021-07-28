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

use App\Http\Requests\aportacionesRequest;
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

class aportacionesController extends Controller
{

    public function actionBuscarApor(Request $request)
    {
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');                        

        $regbancos  = regBancosModel::select('BANCO_ID','BANCO_DESC')->get();
        $regmeses   = regMesesModel::select('MES_ID','MES_DESC')->get();
        $regperiodos= regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                      ->get();  
        $regiap     = regIapModel::select('IAP_ID','IAP_DESC','IAP_CALLE')->orderBy('IAP_DESC','asc')->get();

        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//
        //**************************************************************//
        $per     = $request->get('per');   
        $iapp    = $request->get('iapp');  
        $bio     = $request->get('bio');    
        $regapor = regAportacionesModel::orderBy('APOR_FOLIO', 'ASC')
                   ->per($per)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                   ->iapp($iapp)         //Metodos personalizados
                   //->bio($bio)           //Metodos personalizados
                   ->paginate(30);
        if($regapor->count() <= 0){
            toastr()->error('No existen registros de aportaciones monetarias.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }       
        return view('sicinar.aportaciones.verApor',compact('nombre','usuario','regiap','regapor', 'regbancos', 'regmeses','regperiodos'));     
        //return view('sicinar.aportaciones.verApor',compact('nombre','usuario','regapor'));         
    }


    //*********** Mostrar las aportaciones ***************//
    public function actionVerApor(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');                

        $regbancos  = regBancosModel::select('BANCO_ID', 'BANCO_DESC')->get();
        $regmeses   = regMesesModel::select('MES_ID', 'MES_DESC')->get();
        $regperiodos= regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                      ->get();          
        $regiap     = regIapModel::select('IAP_ID', 'IAP_DESC')->orderBy('IAP_DESC','asc')->get();
        if(session()->get('rango') !== '0'){                           
            $regapor= regAportacionesModel::select('APOR_FOLIO','PERIODO_ID','IAP_ID','MES_ID','BANCO_ID',
                      'APOR_NOCHEQUE','APOR_CONCEPTO','APOR_MONTO','APOR_ENTREGA','APOR_RECIBE','APOR_COMPDEPO',
                      'APOR_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                      ->orderBy('APOR_FOLIO','ASC')
                      ->paginate(30);
        }else{
            $regapor= regAportacionesModel::select('APOR_FOLIO','PERIODO_ID','IAP_ID','MES_ID','BANCO_ID',
                      'APOR_NOCHEQUE','APOR_CONCEPTO','APOR_MONTO','APOR_ENTREGA','APOR_RECIBE','APOR_COMPDEPO',
                      'APOR_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                      ->where('IAP_ID',$arbol_id)            
                      ->orderBy('APOR_FOLIO','ASC')
                      ->paginate(30);
        }          
        if($regapor->count() <= 0){
            toastr()->error('No existen registros de aportaciones monetarias.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaApor');
        }
        return view('sicinar.aportaciones.verApor',compact('nombre','usuario','regapor','regiap','regmeses','regbancos','regperiodos'));
    }

    public function actionNuevaApor(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');                        

        $regbancos  = regBancosModel::select('BANCO_ID', 'BANCO_DESC')
                      ->orderBy('BANCO_DESC','asc')
                      ->get();
        $regmeses   = regMesesModel::select('MES_ID', 'MES_DESC')
                      ->orderBy('MES_ID','asc')
                      ->get();
        $regperiodos= regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')
                      ->orderBy('PERIODO_ID','asc')
                      ->get();        
        if(session()->get('rango') !== '0'){                          
            $regiap = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                      ->get();                                                        
        }else{
            $regiap = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                      ->where('IAP_ID',$arbol_id)
                      ->get();            
        }                    

        $regapor    = regAportacionesModel::select('APOR_FOLIO','PERIODO_ID','IAP_ID','MES_ID','BANCO_ID','APOR_NOCHEQUE',
                      'APOR_CONCEPTO','APOR_MONTO','APOR_ENTREGA','APOR_RECIBE','APOR_COMPDEPO','APOR_STATUS',
                      'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                      ->orderBy('APOR_FOLIO','ASC')
                      ->get();        
        //dd($unidades);
        return view('sicinar.aportaciones.nuevaApor',compact('regbancos','regmeses','regiap','nombre','usuario','regapor','regperiodos'));
    }

    public function actionAltaNuevaApor(Request $request){
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

        /************ Registro de la aportación monetaria *****************************/ 
        $apor_folio = regAportacionesModel::max('APOR_FOLIO');
        $apor_folio = $apor_folio+1;

        $nuevaapor = new regAportacionesModel();
        $name1 =null;
        //Comprobar  si el campo foto1 tiene un archivo asignado:
        if($request->hasFile('apor_compdepo')){
           $name1 = $apor_folio.'_'.$request->file('apor_compdepo')->getClientOriginalName(); 
           //$file->move(public_path().'/images/', $name1);
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('apor_compdepo')->move(public_path().'/images/', $name1);
        }
        $nuevaapor->APOR_FOLIO   = $apor_folio;
        $nuevaapor->PERIODO_ID   = $request->periodo_id;
        $nuevaapor->IAP_ID       = $request->iap_id;        
        $nuevaapor->MES_ID       = $request->mes_id;
        $nuevaapor->BANCO_ID     = $request->banco_id;        
        $nuevaapor->APOR_CONCEPTO= strtoupper($request->apor_concepto);
        $nuevaapor->APOR_NOCHEQUE= strtoupper($request->apor_nocheque);
        $nuevaapor->APOR_MONTO   = $request->apor_monto;        
        $nuevaapor->APOR_ENTREGA = strtoupper($request->apor_entrega);
        $nuevaapor->APOR_RECIBE  = strtoupper($request->apor_recibe);
        $nuevaapor->APOR_COMPDEPO= $name1;
        $nuevaapor->IP           = $ip;
        $nuevaapor->LOGIN        = $nombre;         // Usuario ;
        $nuevaapor->save();

        if($nuevaapor->save() == true){
            toastr()->success('Aportación monetaria registrada correctamente.',' dada de alta!',['positionClass' => 'toast-bottom-right']);


            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         4;
            $xfuncion_id  =      4003;
            $xtrx_id      =       155;    //Registro de aportaciones monetarias
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                           'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 
                           'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $apor_folio])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $apor_folio;     // Folio    
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
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $apor_folio])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,
                                        'TRX_ID' => $xtrx_id,'FOLIO' => $apor_folio])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/             
            //return redirect()->route('nuevaIap');
            //return view('sicinar.plandetrabajo.nuevoPlan',compact('unidades','nombre','usuario','rango','preguntas','apartados'));
        }else{
            toastr()->error('Error inesperado al registrar la aportación monetaria. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            //return back();
            //return redirect()->route('nuevaApor');
        }

        return redirect()->route('verApor');
    }

    
    /****************** Editar registro de aportación monetaria **********/
    public function actionEditarApor($id){
        $nombre     = session()->get('userlog');
        $pass       = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario    = session()->get('usuario');
        $rango      = session()->get('rango'); 
        $arbol_id   = session()->get('arbol_id');                        

        $regbancos  = regBancosModel::select('BANCO_ID', 'BANCO_DESC')->orderBy('BANCO_DESC','asc')
                      ->get();
        $regmeses   = regMesesModel::select('MES_ID', 'MES_DESC')->orderBy('MES_ID','asc')
                      ->get();
        $regperiodos= regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->orderBy('PERIODO_ID','asc')
                      ->get();        
        if(session()->get('rango') !== '0'){                          
            $regiap = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                      ->get();                                                        
        }else{
            $regiap = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                      ->where('IAP_ID',$arbol_id)
                      ->get();            
        }                    
        $regapor    = regAportacionesModel::select('APOR_FOLIO','PERIODO_ID','IAP_ID','MES_ID','BANCO_ID',
                      'APOR_NOCHEQUE','APOR_CONCEPTO','APOR_MONTO','APOR_ENTREGA','APOR_RECIBE','APOR_COMPDEPO',
                      'APOR_STATUS','FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                      ->where('APOR_FOLIO',$id)
                      ->first();
        if($regapor->count() <= 0){
            toastr()->error('No existe registro de aportación monetaria.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('nuevaApor');
        }
        return view('sicinar.aportaciones.editarApor',compact('nombre','usuario','regiap','regbancos','regmeses','regperiodos', 'regapor'));

    }

    public function actionActualizarApor(aportacionesRequest $request, $id){
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
            //***************** actualizar *****************************/      
            $regapor = regAportacionesModel::where('APOR_FOLIO',$id)        
            ->update([                
                'PERIODO_ID'    => $request->periodo_id,                
                'IAP_ID'        => $request->iap_id,                  
                'MES_ID'        => $request->mes_id,
                'BANCO_ID'      => $request->banco_id,                
                'APOR_CONCEPTO' => strtoupper($request->apor_concepto),
                'APOR_MONTO'    => $request->apor_monto,
                'APOR_NOCHEQUE' => strtoupper($request->apor_nocheque),
                'APOR_ENTREGA'  => strtoupper($request->apor_entrega),
                'APOR_RECIBE'   => strtoupper($request->apor_recibe),                
                'IP_M'          => $ip,
                'LOGIN_M'       => $nombre,
                'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')                                
            ]);
            toastr()->success('Aportación monetaria actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

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
        }       /************ Termina de actualizar ********************************/

        return redirect()->route('verApor');
        //return view('sicinar.catalogos.verProceso',compact('nombre','usuario','regproceso'));
    }


    public function actionBorrarApor($id){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        /************ Cancela movimiento de aportación monetaria **************************************/
        $regapor = regAportacionesModel::where('APOR_FOLIO',$id);
        if($regapor->count() <= 0)
            toastr()->error('No existe aportacion monetaria.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //**************** Elimina aportación *******************/
            $regapor->delete();
            toastr()->success('Aportación monetaria eliminada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre aboorar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         4;
            $xfuncion_id  =      4003;
            $xtrx_id      =       157;     // Cancelación de la aportacion monetaria
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
                    toastr()->error('Error inesperado al dar de alta en la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
        }       /************ Termina de eliminar aportación monetaria *************/
        
        return redirect()->route('verApor');
    }    


}
