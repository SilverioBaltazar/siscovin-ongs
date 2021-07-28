<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 

Route::get('/', function () {
    return view('sicinar.login.loginInicio');
});

    Route::group(['prefix' => 'control-interno'], function() {
    Route::post('menu', 'usuariosController@actionLogin')->name('login');
    Route::get('status-sesion/expirada', 'usuariosController@actionExpirada')->name('expirada');
    Route::get('status-sesion/terminada', 'usuariosController@actionCerrarSesion')->name('terminada');
  
    // Auto registro en sistema
    Route::get( 'Autoregistro/usuario'              ,'usuariosController@actionAutoregUsu')->name('autoregusu');
    Route::post('Autoregistro/usuario/registro'     ,'usuariosController@actionRegaltaUsu')->name('regaltausu');

    // BackOffice del sistema
    Route::get('BackOffice/usuarios'                ,'usuariosController@actionNuevoUsuario')->name('nuevoUsuario');
    Route::post('BackOffice/usuarios/alta'          ,'usuariosController@actionAltaUsuario')->name('altaUsuario');
    Route::get('BackOffice/buscar/todos'            ,'usuariosController@actionBuscarUsuario')->name('buscarUsuario');        
    Route::get('BackOffice/usuarios/todos'          ,'usuariosController@actionVerUsuario')->name('verUsuarios');
    Route::get('BackOffice/usuarios/{id}/editar'    ,'usuariosController@actionEditarUsuario')->name('editarUsuario');
    Route::put('BackOffice/usuarios/{id}/actualizar','usuariosController@actionActualizarUsuario')->name('actualizarUsuario');
    Route::get('BackOffice/usuarios/{id}/Borrar'    ,'usuariosController@actionBorrarUsuario')->name('borrarUsuario');    
    Route::get('BackOffice/usuario/{id}/activar'    ,'usuariosController@actionActivarUsuario')->name('activarUsuario');
    Route::get('BackOffice/usuario/{id}/desactivar' ,'usuariosController@actionDesactivarUsuario')->name('desactivarUsuario');

    Route::get('BackOffice/usuario/{id}/{id2}/email','usuariosController@actionEmailRegistro')->name('emailregistro');    

    //Catalogos
    //Procesos
    Route::get('proceso/nuevo'      ,'catalogosController@actionNuevoProceso')->name('nuevoProceso');
    Route::post('proceso/nuevo/alta','catalogosController@actionAltaNuevoProceso')->name('AltaNuevoProceso');
    Route::get('proceso/ver/todos'  ,'catalogosController@actionVerProceso')->name('verProceso');
    Route::get('proceso/{id}/editar/proceso','catalogosController@actionEditarProceso')->name('editarProceso');
    Route::put('proceso/{id}/actualizar'    ,'catalogosController@actionActualizarProceso')->name('actualizarProceso');
    Route::get('proceso/{id}/Borrar','catalogosController@actionBorrarProceso')->name('borrarProceso');    
    Route::get('proceso/excel'      ,'catalogosController@exportCatProcesosExcel')->name('downloadprocesos');
    Route::get('proceso/pdf'        ,'catalogosController@exportCatProcesosPdf')->name('catprocesosPDF');
    //Funciones de procesos
    Route::get('funcion/nuevo'      ,'catalogosfuncionesController@actionNuevaFuncion')->name('nuevaFuncion');
    Route::post('funcion/nuevo/alta','catalogosfuncionesController@actionAltaNuevaFuncion')->name('AltaNuevaFuncion');
    Route::get('funcion/ver/todos'  ,'catalogosfuncionesController@actionVerFuncion')->name('verFuncion');
    Route::get('funcion/{id}/editar/funcion','catalogosfuncionesController@actionEditarFuncion')->name('editarFuncion');
    Route::put('funcion/{id}/actualizar'    ,'catalogosfuncionesController@actionActualizarFuncion')->name('actualizarFuncion');
    Route::get('funcion/{id}/Borrar','catalogosfuncionesController@actionBorrarFuncion')->name('borrarFuncion');    
    Route::get('funcion/excel'      ,'catalogosfuncionesController@exportCatFuncionesExcel')->name('downloadfunciones');
    Route::get('funcion/pdf'        ,'catalogosfuncionesController@exportCatFuncionesPdf')->name('catfuncionesPDF');    
    //Actividades
    Route::get('actividad/nuevo'      ,'catalogostrxController@actionNuevaTrx')->name('nuevaTrx');
    Route::post('actividad/nuevo/alta','catalogostrxController@actionAltaNuevaTrx')->name('AltaNuevaTrx');
    Route::get('actividad/ver/todos'  ,'catalogostrxController@actionVerTrx')->name('verTrx');
    Route::get('actividad/{id}/editar/actividad','catalogostrxController@actionEditarTrx')->name('editarTrx');
    Route::put('actividad/{id}/actualizar'      ,'catalogostrxController@actionActualizarTrx')->name('actualizarTrx');
    Route::get('actividad/{id}/Borrar','catalogostrxController@actionBorrarTrx')->name('borrarTrx');    
    Route::get('actividad/excel'      ,'catalogostrxController@exportCatTrxExcel')->name('downloadtrx');
    Route::get('actividad/pdf'        ,'catalogostrxController@exportCatTrxPdf')->name('cattrxPDF');
    //Rubros sociales
    Route::get('rubro/nuevo'      ,'catalogosrubrosController@actionNuevoRubro')->name('nuevoRubro');
    Route::post('rubro/nuevo/alta','catalogosrubrosController@actionAltaNuevoRubro')->name('AltaNuevoRubro');
    Route::get('rubro/ver/todos'  ,'catalogosrubrosController@actionVerRubro')->name('verRubro');
    Route::get('rubro/{id}/editar/rubro','catalogosrubrosController@actionEditarRubro')->name('editarRubro');
    Route::put('rubro/{id}/actualizar'  ,'catalogosrubrosController@actionActualizarRubro')->name('actualizarRubro');
    Route::get('rubro/{id}/Borrar','catalogosrubrosController@actionBorrarRubro')->name('borrarRubro');    
    Route::get('rubro/excel'      ,'catalogosrubrosController@exportCatRubrosExcel')->name('downloadrubros');
    Route::get('rubro/pdf'        ,'catalogosrubrosController@exportCatRubrosPdf')->name('catrubrosPDF');    
    //Imnuebles edo.
    Route::get('inmuebleedo/nuevo'      ,'catalogosinmueblesedoController@actionNuevoInmuebleedo')->name('nuevoInmuebleedo');
    Route::post('inmuebleedo/nuevo/alta','catalogosinmueblesedoController@actionAltaNuevoInmuebleedo')->name('AltaNuevoInmuebleedo');
    Route::get('inmuebleedo/ver/todos'  ,'catalogosinmueblesedoController@actionVerInmuebleedo')->name('verInmuebleedo');
    Route::get('inmuebleedo/{id}/editar/rubro','catalogosinmueblesedoController@actionEditarInmuebleedo')->name('editarInmuebleedo');
    Route::put('inmuebleedo/{id}/actualizar'  ,'catalogosinmueblesedoController@actionActualizarInmuebleedo')->name('actualizarInmuebleedo');
    Route::get('inmuebleedo/{id}/Borrar','catalogosinmueblesedoController@actionBorrarInmuebleedo')->name('borrarInmuebleedo');
    Route::get('inmuebleedo/excel'      ,'catalogosinmueblesedoController@exportCatInmueblesedoExcel')->name('downloadinmueblesedo');
    Route::get('inmuebleedo/pdf'        ,'catalogosinmueblesedoController@exportCatInmueblesedoPdf')->name('catinmueblesedoPDF');
    //tipos de archivos
    Route::get('formato/nuevo'              ,'catformatosController@actionNuevoFormato')->name('nuevoFormato');
    Route::post('formato/nuevo/alta'        ,'catformatosController@actionAltaNuevoFormato')->name('AltaNuevoFormato');
    Route::get('formato/ver/todos'          ,'catformatosController@actionVerFormatos')->name('verFormatos');
    Route::get('formato/{id}/editar/formato','catformatosController@actionEditarFormato')->name('editarFormato');
    Route::put('formato/{id}/actualizar'    ,'catformatosController@actionActualizarFormato')->name('actualizarFormato');
    Route::get('formato/{id}/Borrar'        ,'catformatosController@actionBorrarFormato')->name('borrarFormato');    
    //Route::get('formato/excel'            ,'catformatosController@exportCatRubrosExcel')->name('downloadrubros');
    //Route::get('formato/pdf'              ,'catformatosController@exportCatRubrosPdf')->name('catrubrosPDF');     

    //catalogo de documentos
    Route::get('docto/buscar/todos'        ,'catdoctosController@actionBuscarDocto')->name('buscarDocto');    
    Route::get('docto/nuevo'               ,'catdoctosController@actionNuevoDocto')->name('nuevoDocto');
    Route::post('docto/nuevo/alta'         ,'catdoctosController@actionAltaNuevoDocto')->name('AltaNuevoDocto');
    Route::get('docto/ver/todos'           ,'catdoctosController@actionVerDoctos')->name('verDoctos');
    Route::get('docto/{id}/editar/formato' ,'catdoctosController@actionEditarDocto')->name('editarDocto');
    Route::put('docto/{id}/actualizar'     ,'catdoctosController@actionActualizarDocto')->name('actualizarDocto');    
    Route::get('docto/{id}/editar/formato1','catdoctosController1@actionEditarDocto1')->name('editarDocto1');
    Route::put('docto/{id}/actualizar1'    ,'catdoctosController1@actionActualizarDocto1')->name('actualizarDocto1');
    Route::get('docto/{id}/Borrar'         ,'catdoctosController@actionBorrarDocto')->name('borrarDocto');    
    Route::get('docto/excel'               ,'catdoctosController@exportCatDoctosExcel')->name('catDoctosExcel');
    Route::get('docto/pdf'                 ,'catdoctosController@exportCatDoctosPdf')->name('catDoctosPDF');     

    //Municipios sedesem
    Route::get('municipio/ver/todos','catalogosmunicipiosController@actionVermunicipios')->name('verMunicipios');
    Route::get('municipio/excel'    ,'catalogosmunicipiosController@exportCatmunicipiosExcel')->name('downloadmunicipios');
    Route::get('municipio/pdf'      ,'catalogosmunicipiosController@exportCatmunicipiosPdf')->name('catmunicipiosPDF');

    //OSC
    //Directorio
    Route::get('oscs/nueva'           ,'oscController@actionNuevaOsc')->name('nuevaOsc');
    Route::post('oscs/nueva/alta'     ,'oscController@actionAltaNuevaOsc')->name('AltaNuevaOsc');
    Route::get('oscs/ver/todas'       ,'oscController@actionVerOsc')->name('verOsc');
    Route::get('oscs/buscar/todas'    ,'oscController@actionBuscarOsc')->name('buscarOsc');    
    Route::get('oscs/{id}/editar/oscs','oscController@actionEditarOsc')->name('editarOsc');
    Route::put('oscs/{id}/actualizar' ,'oscController@actionActualizarOsc')->name('actualizarOsc');
    Route::get('oscs/{id}/Borrar'     ,'oscController@actionBorrarOsc')->name('borrarOsc');
    Route::get('oscs/excel'           ,'oscController@exportOscExcel')->name('oscexcel');
    Route::get('oscs/pdf'             ,'oscController@exportOscPdf')->name('oscPDF');

    Route::get('oscs/{id}/editar/osc1','oscController@actionEditarOsc1')->name('editarOsc1');
    Route::put('oscs/{id}/actualizar1','oscController@actionActualizarOsc1')->name('actualizarOsc1'); 
    Route::get('oscs/{id}/editar/osc2','oscController@actionEditarOsc2')->name('editarOsc2');
    Route::put('oscs/{id}/actualizar2','oscController@actionActualizarOsc2')->name('actualizarOsc2');        
 
    Route::get('oscs5/ver/todas'       ,'oscController@actionVerOsc5')->name('verOsc5');
    Route::get('oscs5/{id}/editar/oscs','oscController@actionEditarOsc5')->name('editarOsc5');
    Route::put('oscs5/{id}/actualizar' ,'oscController@actionActualizarOsc5')->name('actualizarOsc5');    
    
    //Instituciones de Asistencia Privada (IAPS)
    //Directorio
    Route::get('iaps/nueva'           ,'iapsController@actionNuevaIap')->name('nuevaIap');
    Route::post('iaps/nueva/alta'     ,'iapsController@actionAltaNuevaIap')->name('AltaNuevaIap');
    Route::get('iaps/ver/todas'       ,'iapsController@actionVerIap')->name('verIap');
    Route::get('iaps/buscar/todas'    ,'iapsController@actionBuscarIap')->name('buscarIap');    
    Route::get('iaps/{id}/editar/iaps','iapsController@actionEditarIap')->name('editarIap');
    Route::put('iaps/{id}/actualizar' ,'iapsController@actionActualizarIap')->name('actualizarIap');
    Route::get('iaps/{id}/Borrar'     ,'iapsController@actionBorrarIap')->name('borrarIap');
    Route::get('iaps/excel'           ,'iapsController@exportCatIapsExcel')->name('downloadiap');
    Route::get('iaps/pdf'             ,'iapsController@exportCatIapsPdf')->name('catiapPDF');

    Route::get('iaps/{id}/editar/iaps1','iapsController1@actionEditarIap1')->name('editarIap1');
    Route::put('iaps/{id}/actualizar1' ,'iapsController1@actionActualizarIap1')->name('actualizarIap1'); 
    Route::get('iaps/{id}/editar/iaps2','iapsController2@actionEditarIap2')->name('editarIap2');
    Route::put('iaps/{id}/actualizar2' ,'iapsController2@actionActualizarIap2')->name('actualizarIap2');        

    Route::get('iaps5/ver/todas'       ,'iapsController@actionVerIap5')->name('verIap5');
    Route::get('iaps5/{id}/editar/iaps','iapsController@actionEditarIap5')->name('editarIap5');
    Route::put('iaps5/{id}/actualizar' ,'iapsController@actionActualizarIap5')->name('actualizarIap5');    

    //IAPS Aportaciones monetarias
    Route::get('aportaciones/nueva'            ,'aportacionesController@actionNuevaApor')->name('nuevaApor');
    Route::post('aportaciones/nueva/alta'      ,'aportacionesController@actionAltaNuevaApor')->name('AltaNuevaApor');
    Route::get('aportaciones/ver/todas'        ,'aportacionesController@actionVerApor')->name('verApor');
    Route::get('aportaciones/buscar/todas'     ,'aportacionesController@actionBuscarApor')->name('buscarApor');
    Route::get('aportaciones/{id}/editar/iaps' ,'aportacionesController@actionEditarApor')->name('editarApor');
    Route::put('aportaciones/{id}/actualizar'  ,'aportacionesController@actionActualizarApor')->name('actualizarApor');
    Route::get('aportaciones/{id}/editar/iaps1','aportacionesController1@actionEditarApor1')->name('editarApor1');
    Route::put('aportaciones/{id}/actualizar1' ,'aportacionesController1@actionActualizarApor1')->name('actualizarApor1');    
    Route::get('aportaciones/{id}/Borrar'      ,'aportacionesController@actionBorrarApor')->name('borrarApor');
    //Route::get('aportaciones/excel'           ,'aportacionesController@exportAporExcel')->name('aporExcel');
    //Route::get('aportaciones/pdf'             ,'aportacionesController@exportAporPdf')->name('aporPDF');    

    //Cursos de capacitación
    Route::get('cursos/nuevo'            ,'cursosController@actionNuevoCurso')->name('nuevoCurso');
    Route::post('cursos/nuevo/alta'      ,'cursosController@actionAltaNuevoCurso')->name('AltaNuevoCurso');
    Route::get('cursos/ver/todos'        ,'cursosController@actionVerCursos')->name('verCursos');
    Route::get('cursos/{id}/editar/curso','cursosController@actionEditarCurso')->name('editarCurso');
    Route::put('cursos/{id}/actualizar'  ,'cursosController@actionActualizarCurso')->name('actualizarCurso');
    Route::get('cursos/{id}/Borrar'      ,'cursosController@actionBorrarCurso')->name('borrarCurso');
    //Route::get('aportaciones/excel'           ,'aportacionesController@exportAporExcel')->name('aporExcel');
    //Route::get('aportaciones/pdf'             ,'aportacionesController@exportAporPdf')->name('aporPDF');    
      
    //Requisitos Jurídicos
    Route::get('rjuridicos/nueva'              ,'rJuridicosController@actionNuevaJur')->name('nuevaJur');
    Route::post('rjuridicos/nueva/alta'        ,'rJuridicosController@actionAltaNuevaJur')->name('AltaNuevaJur');  
    Route::get('rjuridicos/buscar/todos'       ,'rJuridicosController@actionBuscarJur')->name('buscarJur');          
    Route::get('rjuridicos/ver/todasj'         ,'rJuridicosController@actionVerJur')->name('verJur');
    Route::get('rjuridicos/{id}/editar/iapsj'  ,'rJuridicosController@actionEditarJur')->name('editarJur');
    Route::put('rjuridicos/{id}/actualizarj'   ,'rJuridicosController@actionActualizarJur')->name('actualizarJur'); 
    Route::get('rjuridicos/{id}/Borrarj'       ,'rJuridicosController@actionBorrarJur')->name('borrarJur');

    Route::get('rjuridicos/{id}/editar/iapsj12','rJuridicosController@actionEditarJur12')->name('editarJur12');
    Route::put('rjuridicos/{id}/actualizarj12' ,'rJuridicosController@actionActualizarJur12')->name('actualizarJur12');    
    Route::get('rjuridicos/{id}/editar/iapsj13','rJuridicosController@actionEditarJur13')->name('editarJur13');
    Route::put('rjuridicos/{id}/actualizarj13' ,'rJuridicosController@actionActualizarJur13')->name('actualizarJur13'); 
    Route::get('rjuridicos/{id}/editar/iapsj14','rJuridicosController@actionEditarJur14')->name('editarJur14');
    Route::put('rjuridicos/{id}/actualizarj14' ,'rJuridicosController@actionActualizarJur14')->name('actualizarJur14');
    Route::get('rjuridicos/{id}/editar/iapsj15','rJuridicosController@actionEditarJur15')->name('editarJur15');
    Route::put('rjuridicos/{id}/actualizarj15' ,'rJuridicosController@actionActualizarJur15')->name('actualizarJur15');

    //Requisitos jurídicos
    //Padron de beneficiarios
    Route::get('padron/nueva'           ,'padronController@actionNuevoPadron')->name('nuevoPadron');
    Route::post('padron/nueva/alta'     ,'padronController@actionAltaNuevoPadron')->name('AltaNuevoPadron');
    Route::get('padron/ver/todas'       ,'padronController@actionVerPadron')->name('verPadron');
    Route::get('padron/buscar/todas'    ,'padronController@actionBuscarPadron')->name('buscarPadron');    
    Route::get('padron/{id}/editar/padron','padronController@actionEditarPadron')->name('editarPadron');
    Route::put('padron/{id}/actualizar' ,'padronController@actionActualizarPadron')->name('actualizarPadron');
    Route::get('padron/{id}/Borrar'     ,'padronController@actionBorrarPadron')->name('borrarPadron');
    Route::get('padron/excel'           ,'padronController@actionExportPadronExcel')->name('ExportPadronExcel');
    Route::get('padron/pdf'             ,'padronController@actionExportPadronPdf')->name('ExportPadronPdf');

    //Plantilla de personal
    Route::get('personal/nueva'           ,'personalController@actionNuevoPersonal')->name('nuevoPersonal');
    Route::post('personal/nueva/alta'     ,'personalController@actionAltaNuevoPersonal')->name('AltaNuevoPersonal');
    Route::get('personal/ver/todas'       ,'personalController@actionVerPersonal')->name('verPersonal');
    Route::get('personal/buscar/todas'    ,'personalController@actionBuscarPersonal')->name('buscarPersonal');    
    Route::get('personal/{id}/editar/personal','personalController@actionEditarPersonal')->name('editarPersonal');
    Route::put('personal/{id}/actualizar' ,'personalController@actionActualizarPersonal')->name('actualizarPersonal');
    Route::get('personal/{id}/Borrar'     ,'personalController@actionBorrarPersonal')->name('borrarPersonal');
    Route::get('personal/excel'           ,'personalController@actionExportPersonalExcel')->name('ExportPersonalExcel');
    Route::get('personal/pdf'             ,'personalController@actionExportPersonalPdf')->name('ExportPersonalPdf');

    Route::get('personal/{id}/municipios','personalController@EntidadMunicipios')->name('Entidadmunicipios');
    Route::get('municipios/{id}'         ,'personalController@EntidadMunicipios');

    //Programa de trabajo
    Route::get('programat/nuevo'           ,'progtrabController@actionNuevoProgtrab')->name('nuevoProgtrab');
    Route::post('programat/nuevo/alta'     ,'progtrabController@actionAltaNuevoProgtrab')->name('AltaNuevoProgtrab');
    Route::get('programat/ver/todos'       ,'progtrabController@actionVerProgtrab')->name('verProgtrab');
    Route::get('programat/buscar/todos'    ,'progtrabController@actionBuscarProgtrab')->name('buscarProgtrab');    
    Route::get('programat/{id}/editar/progt','progtrabController@actionEditarProgtrab')->name('editarProgtrab');
    Route::put('programat/{id}/actualizar' ,'progtrabController@actionActualizarProgtrab')->name('actualizarProgtrab');
    Route::get('programat/{id}/Borrar'     ,'progtrabController@actionBorrarProgtrab')->name('borrarProgtrab');
    Route::get('programat/excel/{id}'      ,'progtrabController@actionExportProgtrabExcel')->name('ExportProgtrabExcel');
    Route::get('programat/pdf/{id}/{id2}'  ,'progtrabController@actionExportProgtrabPdf')->name('ExportProgtrabPdf');

    Route::get('programadt/{id}/nuevo'         ,'progtrabController@actionNuevoProgdtrab')->name('nuevoProgdtrab');
    Route::post('programadt/nuevo/alta'   ,'progtrabController@actionAltaNuevoProgdtrab')->name('AltaNuevoProgdtrab');
    Route::get('programadt/{id}/ver/todosd'         ,'progtrabController@actionVerProgdtrab')->name('verProgdtrab');
    Route::get('programadt/{id}/{id2}/editar/progdt','progtrabController@actionEditarProgdtrab')->name('editarProgdtrab');
    Route::put('programadt/{id}/{id2}/actualizardt' ,'progtrabController@actionActualizarProgdtrab')->name('actualizarProgdtrab');
    Route::get('programadt/{id}/{id2}/Borrardt','progtrabController@actionBorrarProgdtrab')->name('borrarProgdtrab');

    //Cedula de detección de necesidades
    Route::get('cedula/nuevo'           ,'cedulaController@actionNuevaCedula')->name('nuevaCedula');
    Route::post('cedula/nuevo/alta'     ,'cedulaController@actionAltaNuevaCedula')->name('AltaNuevaCedula');
    Route::get('cedula/ver/todos'       ,'cedulaController@actionVerCedula')->name('verCedula');
    Route::get('cedula/buscar/todos'    ,'cedulaController@actionBuscarCedula')->name('buscarCedula');    
    Route::get('cedula/{id}/editar/progt','cedulaController@actionEditarCedula')->name('editarCedula');
    Route::put('cedula/{id}/actualizar' ,'cedulaController@actionActualizarCedula')->name('actualizarCedula');
    Route::get('cedula/{id}/Borrar'     ,'cedulaController@actionBorrarCedula')->name('borrarCedula');
    Route::get('cedula/excel/{id}'      ,'cedulaController@actionExportvExcel')->name('ExportCedulaExcel');
    Route::get('cedula/pdf/{id}/{id2}'  ,'cedulaController@actionExportCedulaPdf')->name('ExportCedulaPdf');

    Route::get('cedulaart/{id}/{id2}/nuevo','cedulaController@actionNuevaCedulaarti')->name('nuevaCedulaarti');
    Route::post('cedulaarti/nuevo/alta'    ,'cedulaController@actionAltaNuevaCedulaarti')->name('AltaNuevaCedulaarti');
    Route::get('cedulaarti/{id}/{id2}/ver/todosa'             ,'cedulaController@actionVerCedulaarti')->name('verCedulaarti');
    Route::get('cedulaarti/{id}/{id2}/{id3}/editar/cedarti'   ,'cedulaController@actionEditarCedulaarti')->name('editarCedulaarti');
    Route::put('cedulaarti/{id}/{id2}/{id3}/actualizarcedarti','cedulaController@actionActualizarCedulaarti')->name('actualizarCedulaarti');
    Route::get('cedulaarti/{id}/{id2}/Borrarca','cedulaController@actionBorrarCedulaarti')->name('borrarCedulaarti');

    //Informe de labores - Programa de trabajo
    //Route::get('informe/nuevo'           ,'informeController@actionNuevoInforme')->name('nuevoInforme');
    //Route::post('informe/nuevo/alta'     ,'informeController@actionAltaNuevoInforme')->name('AltaNuevoInforme');
    Route::get('informe/ver/todos'       ,'informeController@actionVerInformes')->name('verInformes');
    Route::get('informe/buscar/todos'    ,'informeController@actionBuscarInforme')->name('buscarInforme');    
    //Route::get('informe/{id}/editar/inflab','informeController@actionEditarInforme')->name('editarInforme');
    //Route::put('informe/{id}/actualizar' ,'informeController@actionActualizarInforme')->name('actualizarInforme');
    //Route::get('informe/{id}/Borrar'     ,'informeController@actionBorrarInforme')->name('borrarInforme');
    //Route::get('informe/excel/{id}'      ,'informeController@actionExportInformeExcel')->name('ExportInformeExcel');
    Route::get('informe/pdf/{id}/{id2}'  ,'informeController@actionExportInformePdf')->name('ExportInformePdf');

    Route::get('informe/{id}/ver/todosi','informeController@actionVerInformelab')->name('verInformelab');
    //Route::get('informe/{id}/nuevo'     ,'informeController@actionNuevoInformelab')->name('nuevoInformelab');
    //Route::post('informe/nuevo/alta'    ,'informeController@actionAltaNuevoInformelab')->name('altaNuevoInformelab'); 
    Route::get('informe/{id}/{id2}/editar/inflabdet'    ,'informeController@actionEditarInformelab')->name('editarInformelab');
    Route::put('informe/{id}/{id2}/actualizarinflabdet' ,'informeController@actionActualizarInformelab')->name('actualizarInformelab');
    //Route::get('informe/{id}/{id2}/Borrarinflabdet'     ,'informeController@actionBorrarInformelab')->name('borrarInformelab');

    //Requisitos asistenciales ojo borrar *****************
    Route::get('rasistencia/nueva'              ,'rAsistenciaController@actionNuevoReqa')->name('nuevoReqa');
    Route::post('rasistencia/nueva/alta'        ,'rAsistenciaController@actionAltaNuevoReqa')->name('AltaNuevoReqa');    
    Route::get('rasistencia/ver/todasa'         ,'rAsistenciaController@actionVerReqa')->name('verReqa');
    Route::get('rasistencia/{id}/editar/reqa'   ,'rAsistenciaController@actionEditarReqa')->name('editarReqa');
    Route::put('rasistencia/{id}/actualizarreqa','rAsistenciaController@actionActualizarReqa')->name('actualizarReqa'); 
    Route::get('rasistencia/{id}/Borrarreqa'    ,'rAsistenciaController@actionBorrarReqa')->name('borrarReqa');

    Route::get('rasistencia/{id}/editar/reqa1'   ,'rAsistenciaController@actionEditarReqa1')->name('editarReqa1');
    Route::put('rasistencia/{id}/actualizarreqa1','rAsistenciaController@actionActualizarReqa1')->name('actualizarReqa1');    
    Route::get('rasistencia/{id}/editar/reqa2'   ,'rAsistenciaController@actionEditarReqa2')->name('editarReqa2');
    Route::put('rasistencia/{id}/actualizarreqa2','rAsistenciaController@actionActualizarReqa2')->name('actualizarReqa2'); 

    Route::get('rasistencia/{id}/editar/reqa3'   ,'rAsistenciaController@actionEditarReqa3')->name('editarReqa3');
    Route::put('rasistencia/{id}/actualizarreqa3','rAsistenciaController@actionActualizarReqa3')->name('actualizarReqa3');    
    Route::get('rasistencia/{id}/editar/reqa4'   ,'rAsistenciaController@actionEditarReqa4')->name('editarReqa4');
    Route::put('rasistencia/{id}/actualizarreqa4','rAsistenciaController@actionActualizarReqa4')->name('actualizarReqa4');    
    Route::get('rasistencia/{id}/editar/reqa5'   ,'rAsistenciaController@actionEditarReqa5')->name('editarReqa5');
    Route::put('rasistencia/{id}/actualizarreqa5','rAsistenciaController@actionActualizarReqa5')->name('actualizarReqa5');

    //Requisitos contables
    Route::get('rcontables/buscar/todos'       ,'rContablesController@actionBuscarReqc')->name('buscarReqc');          
    Route::get('rcontables/ver/todasc'         ,'rContablesController@actionVerReqc')->name('verReqc');
    Route::get('rcontables/nueva'              ,'rContablesController@actionNuevoReqc')->name('nuevoReqc');
    Route::post('rcontables/nueva/alta'        ,'rContablesController@actionAltaNuevoReqc')->name('AltaNuevoReqc');    
    Route::get('rcontables/{id}/editar/reqc'   ,'rContablesController@actionEditarReqc')->name('editarReqc');
    Route::put('rcontables/{id}/actualizarreqc','rContablesController@actionActualizarReqc')->name('actualizarReqc'); 
    Route::get('rcontables/{id}/Borrarreqc'    ,'rContablesController@actionBorrarReqc')->name('borrarReqc');

    Route::get('rcontables/{id}/editarreqc1'    ,'rContablesController@actionEditarReqc1')->name('editarReqc1');
    Route::put('rcontables/{id}/actualizarreqc1','rContablesController@actionActualizarReqc1')->name('actualizarReqc1'); 

    Route::get('rcontables/{id}/editarreqc2'    ,'rContablesController@actionEditarReqc2')->name('editarReqc2');
    Route::put('rcontables/{id}/actualizarreqc2','rContablesController@actionActualizarReqc2')->name('actualizarReqc2');    

    Route::get('rcontables/{id}/editarreqc3'    ,'rContablesController@actionEditarReqc3')->name('editarReqc3');
    Route::put('rcontables/{id}/actualizarreqc3','rContablesController@actionActualizarReqc3')->name('actualizarReqc3');    

     //Requisito contables - Inventario de activo fijo
    Route::get('activo/nueva'           ,'inventarioController@actionNuevoInventario')->name('nuevoInventario');
    Route::post('activo/nueva/alta'     ,'inventarioController@actionAltaNuevoInventario')->name('AltaNuevoInventario');
    Route::get('activo/ver/todos'       ,'inventarioController@actionVerInventarios')->name('verInventarios');
    Route::get('activo/buscar/todos'    ,'inventarioController@actionBuscarInventario')->name('buscarInventario');    
    Route::get('activo/{id}/editar/activo','inventarioController@actionEditarInventario')->name('editarInventario');
    Route::put('activo/{id}/actualizar'   ,'inventarioController@actionActualizarInventario')->name('actualizarInventario');
    Route::get('activo/{id}/Borrar'       ,'inventarioController@actionBorrarInventario')->name('borrarInventario');
    Route::get('activo/excel'           ,'inventarioController@actionExportInventarioExcel')->name('ExportInventarioExcel');
    Route::get('activo/pdf'             ,'inventarioController@actionExportInventarioPdf')->name('ExportInventarioPdf');

     //Requisito contable - Edos financieros, Balnza de comprobación
    Route::get('balanza/nueva'             ,'balanzaController@actionNuevaBalanza')->name('nuevaBalanza');
    Route::post('balanz/nueva/alta'        ,'balanzaController@actionAltaNuevaBalanza')->name('AltaNuevaBalanza');
    Route::get('balanza/ver/todos'         ,'balanzaController@actionVerBalanza')->name('verBalanza');
    Route::get('balanza/buscar/todos'      ,'balanzaController@actionBuscarBalanza')->name('buscarBalanza');    
    Route::get('balanza/{id}/editar/activo','balanzaController@actionEditarBalanza')->name('editarBalanza');
    Route::put('balanza/{id}/actualizar'   ,'balanzaController@actionActualizarBalanza')->name('actualizarBalanza');
    Route::get('balanza/{id}/Borrar'       ,'balanzaController@actionBorrarBalanza')->name('borrarBalanza');
    Route::get('balanza/excel'             ,'balanzaController@actionExportvExcel')->name('ExportBalanzaExcel');
    Route::get('balanza/pdf'               ,'balanzaController@actionExportBalanzaPdf')->name('ExportBalanzaPdf');

    Route::get('balanza/{id}/editar/balanza1'   ,'balanzaController@actionEditarBalanza1')->name('editarBalanza1');
    Route::put('balanza/{id}/actualizarbalanza1','balanzaController@actionActualizarBalanza1')->name('actualizarBalanza1');  

    //Programar diligencias
    Route::get('progdil/nuevo'           ,'progdilController@actionNuevoProgdil')->name('nuevoProgdil');
    Route::post('progdil/nuevo/alta'     ,'progdilController@actionAltaNuevoProgdil')->name('AltaNuevoProgdil');
    Route::get('progdil/ver/todas'       ,'progdilController@actionVerProgdil')->name('verProgdil');
    Route::get('progdil/buscar/todas'    ,'progdilController@actionBuscarProgdil')->name('buscarProgdil');    
    Route::get('progdil/{id}/editar/progdilig','progdilController@actionEditarProgdil')->name('editarProgdil');
    Route::put('progdil/{id}/actualizar' ,'progdilController@actionActualizarProgdil')->name('actualizarProgdil');
    Route::get('progdil/{id}/Borrar'     ,'progdilController@actionBorrarProgdil')->name('borrarProgdil');
    //Route::get('progdil/excel'           ,'progdilController@exportProgdilExcel')->name('ProgdilExcel');
    Route::get('progdil/{id}/pdf'        ,'progdilController@actionMandamientoPDF')->name('mandamientoPDF');

    Route::get('progdil/reporte/reportepv','progdilController@actionReporteProgvisitas')->name('reporteProgvisitas');
    Route::post('progdil/pdf/reportepv'   ,'progdilController@actionProgramavisitasPdf')->name('programavisitasPdf');
    Route::get('progdil/reporte/reportepdf' ,'progdilController@actionReporteProgvisitasExcel')->name('reporteProgvisitasExcel');
    Route::post('progdil/Excel//reporteexel','progdilController@actionProgramavisitasExcel')->name('programavisitasExcel');

    //Visitas de diligencia
    Route::get('visitas/nueva'           ,'visitasController@actionNuevaVisita')->name('nuevaVisita');
    Route::post('visitas/nueva/alta'     ,'visitasController@actionAltaNuevaVisita')->name('altaNuevaVisita');
    Route::get('visitas/ver/todas'         ,'visitasController@actionVerVisitas')->name('verVisitas');
    Route::get('visitas/buscar/todas'      ,'visitasController@actionBuscarVisita')->name('buscarVisita');    
    Route::get('visitas/{id}/editar/visita','visitasController@actionEditarVisita')->name('editarVisita');
    Route::put('visitas/{id}/actualizar'   ,'visitasController@actionActualizarVisita')->name('actualizarVisita');
    Route::get('visitas/{id}/Borrar'       ,'visitasController@actionBorrarVisita')->name('borrarVisita');
   
    //Route::get('visitas/excel'              ,'visitasController@exportVisitasExcel')->name('VisitasExcel');
    Route::get('visitas/{id}/pdfA'          ,'visitasController@actionActaVisitaAPDF')->name('actavisitaAPDF'); 
    Route::get('visitas/{id}/pdfJ'          ,'visitasController@actionActaVisitaJPDF')->name('actavisitaJPDF');    
    Route::get('visitas/{id}/pdfC'          ,'visitasController@actionActaVisitaCPDF')->name('actavisitaCPDF');       

    //Cuestionario de diligencia
    Route::get('question/ver/todos'         ,'questionController@actionVerQuestions')->name('verQuestions');
    Route::get('question/buscar/todos'      ,'questionController@actionBuscarQuestion')->name('buscarQuestion');    
    Route::get('question/nuevo'             ,'questionController@actionNuevoQuestion')->name('nuevoQuestion');
    Route::post('question/nueva/alta'       ,'questionController@actionAltaNuevoQuestion')->name('altaNuevoQuestion');
    Route::get('question/{id}/editar/visita','questionController@actionEditarQuestion')->name('editarQuestion');
    Route::put('question/{id}/actualizar'   ,'questionController@actionActualizarQuestion')->name('actualizarQuestion');
    Route::get('question/{id}/Borrar'       ,'questionController@actionBorrarQuestion')->name('borrarQuestion');
    Route::get('question/{id}/pdf'          ,'questionController@actionQuestionPDF')->name('questionPDF');

    //Tablero de control
    Route::get('indicador/ver/todos'       ,'indicadoresController@actionVerCumplimiento')->name('vercumplimiento');
    Route::get('indicador/buscar/todos'    ,'indicadoresController@actionBuscarCumplimiento')->name('buscarcumplimiento');    
    Route::get('indicador/ver/todasvisitas','indicadoresController@actionVerCumplimientovisitas')->name('vercumplimientovisitas');
    Route::get('indicador/buscar/todasvisitas','indicadoresController@actionBuscarCumplimientovisitas')->name('buscarcumplimientovisitas');    

    // Estadísticas
    // OCS
    Route::get('numeralia/ver/graficaixedo'   ,'oscController@OscxEdo')->name('oscxedo');
    Route::get('numeralia/ver/graficaixmpio'  ,'oscController@OscxMpio')->name('oscxmpio');
    Route::get('numeralia/ver/graficaixrubro' ,'oscController@OscxRubro')->name('oscxrubro');    
    Route::get('numeralia/ver/graficaixfigura','oscController@OscxFigjuridica')->name('oscxfigjuridica');        
    Route::get('numeralia/ver/graficaixrubro2','iapsController@IapxRubro2')->name('iapxrubro2'); 
    Route::get('numeralia/ver/graficaiBitacora','iapsController@Bitacora')->name('bitacora'); 
    Route::get('numeralia/ver/mapas'         ,'iapsController@Mapas')->name('verMapas');        
    Route::get('numeralia/ver/mapas2'        ,'iapsController@Mapas2')->name('verMapas2');        
    Route::get('numeralia/ver/mapas3'        ,'iapsController@Mapas3')->name('verMapas3');        

    //padrón
    Route::get('numeralia/ver/graficapadxedo'  ,'padronController@actionPadronxEdo')->name('padronxedo');
    //Route::get('numeralia/ver/graficapadxmpio' ,'padronController@actionPadronxMpio')->name('padronxmpio');
    Route::get('numeralia/ver/graficapadxserv' ,'padronController@actionPadronxServicio')->name('padronxservicio');
    Route::get('numeralia/ver/graficapadxsexo' ,'padronController@actionPadronxsexo')->name('padronxsexo');
    Route::get('numeralia/ver/graficapadxedad' ,'padronController@actionPadronxedad')->name('padronxedad');
    Route::get('numeralia/ver/graficapadxrangoedad','padronController@actionPadronxRangoedad')->name('padronxrangoedad');

    //Plantilla de personal
    Route::get('numeralia/ver/graficapadxclase'   ,'personalController@actionPersonalxClaseemp')->name('personalxclaseemp');
    Route::get('numeralia/ver/graficapadxTipo'    ,'personalController@actionPersonalxTipoemp')->name('personalxtipoemp');
    Route::get('numeralia/ver/graficapadxEstudios','personalController@actionPersonalxEstudios')->name('personalxestudios');

    //Agenda
    Route::get('numeralia/ver/graficaagenda1'    ,'progdilController@actionVerProgdilGraficaxmes')->name('verprogdilgraficaxmes');    
    Route::post('numeralia/ver/graficaagendaxmes','progdilController@actionProgdilGraficaxmes')->name('progdilgraficaxmes');
    Route::get('numeralia/ver/graficaagenda2'    ,'progdilController@actionVerprogdilGraficaxtipo')->name('verprogdilgraficaxtipo');        
    Route::post('numeralia/ver/graficaagendaxtipo','progdilController@actionProgdilGraficaxtipo')->name('progdilgraficaxtipo');
});

