<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usuarioModel extends Model
{
    protected $table = 'ONG_CTRL_ACCESO';
    protected  $primaryKey = 'LOGIN';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'N_PERIODO', 
	    'CVE_PROGRAMA', 
	    'FOLIO',
	    'CVE_DEPENDENCIA',
        'AP_PATERNO',
        'AP_MATERNO',
        'NOMBRES',
        'NOMBRE_COMPLETO',
        'EMAIL',
	    'LOGIN',
	    'PASSWORD',
	    'TIPO_USUARIO',
        'CVE_ARBOL',
      	'STATUS_1', //TIPO DE USUARIO [3 => ADMIN, 2 => GENERAL, 3 => PARTICULAR]
      	'STATUS_2', //1 ACTIVO      0 INACTIVO
	    'FECHA_REGISTRO'
    ];
}
