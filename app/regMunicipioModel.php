<?php
/*
Clase modelo: regMunicipioModel
Descripción: esta clase se creó para poder utilizar los datos de este catálogo de municipios
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class regMunicipioModel extends Model
{
    protected $table      = "ONG_CAT_MUNICIPIOS_SEDESEM";
    protected $primaryKey = 'MUNICIPIOID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'ENTIDADFEDERATIVAID',
        'MUNICIPIOID',
        'MUNICIPIONOMBRE', //S ACTIVO      N INACTIVO
        'REGIONID',
        'CVE_COORDINACION'
    ];

    /*****************************************************************************************************
    Función Municipios(): Obtiene todos los municipios pertenecientes a la clave de la entidad federativa 
                          igual al parámetro que viene en la función.
    *****************************************************************************************************/    
    public static function Municipios($id){
        return regMunicipioModel::where('ENTIDADFEDERATIVAID',$id)
                                  ->orderBy('MUNICIPIONOMBRE','asc')
                                  ->get();
    }


}