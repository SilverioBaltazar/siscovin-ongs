<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regusuariosModel extends Model
{
    protected $table = 'ONG_CTRL_ACCESO';
    protected  $primaryKey = 'LOGIN';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'N_PERIODO', 
	    'FOLIO', 
        'AP_PATERNO',
        'AP_MATERNO',
        'NOMBRES',
        'NOMBRE_COMPLETO',
	    'LOGIN',
	    'PASSWORD',
        'TELEFONO',
	    'TIPO_USUARIO',
        'CVE_ARBOL',
        'OSC_DESC',
      	'STATUS_1',         // TIPO DE USUARIO [3 => ADMIN, 2 => GENERAL, 3 => PARTICULAR]
      	'STATUS_2',         // 1 ACTIVO      0 INACTIVO
	    'FECHA_REGISTRO'
    ];

    //***************************************//
    // *** Como se usa el query scope  ******//
    //***************************************//
    public function scopeName($query, $name)
    {
        if($name)
            return $query->where('NOMBRE_COMPLETO', 'LIKE', "%$name%");
    }

    public function scopeIdd($query, $idd)
    {
        if($idd)
            return $query->where('CVE_ARBOL', '=', $idd);
    }
    public function scopeLogin($query, $login) 
    {
        if($login)
            return $query->where('LOGIN', 'LIKE', "%$login%");
    }

    public function scopeNameosc($query, $nameosc)
    {
        if($nameosc) 
            return $query->where('OSC_DESC', 'LIKE', "%$nameosc%");
    } 

}
 