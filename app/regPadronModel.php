<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regPadronModel extends Model
{
    protected $table      = "ONG_METADATO_PADRON";
    protected $primaryKey = ['FOLIO','OSC_ID'];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
            'PERIODO_ID',
            'PROGRAMA_ID',
            'FOLIO',
            'OSC_ID',
            'FECHA_INGRESO',
            'FECHA_INGRESO2',
            'PERIODO_ID1',
            'MES_ID1',
            'DIA_ID1',                         
            'PRIMER_APELLIDO',
            'SEGUNDO_APELLIDO',
            'NOMBRES',
            'NOMBRE_COMPLETO',
            'CURP',
            'FECHA_NACIMIENTO',
            'FECHA_NACIMIENTO2',
            'PERIODO_ID2',
            'MES_ID2',
            'DIA_ID2', 
            'SEXO',
            'RFC',
            'ID_OFICIAL',
            'DOMICILIO',
            'COLONIA',
            'CP',
            'ENTRE_CALLE',
            'Y_CALLE',
            'OTRA_REFERENCIA',
            'TELEFONO',
            'CELULAR',
            'E_MAIL',
            'ENTIDAD_NAC_ID',
            'ENTIDAD_FED_ID',
            'MUNICIPIO_ID',
            'LOCALIDAD_ID',
            'LOCALIDAD',
            'EDO_CIVIL_ID',
            'GRADO_ESTUDIOS_ID',
            'MOTIVO_ING',
            'INTEG_FAM',
            'SERVICIO_ID',
            'CUOTA_RECUP',
            'QUIEN_CANALIZO',
            'STATUS_1',
            'STATUS_2',
            'FECHA_REG',
            'IP',
            'LOGIN',
            'FECHA_M',
            'IP_M',
            'LOGIN_M'
    ];

    public static function ObtpadronIap($id){
        return (regPadronModel::select('OSC_ID')->where('OSC_ID','=',$id)
                                ->get());
    }

    public static function obtMunicipios($id){
        return regPadronModel::select('ENTIDADFEDERATIVAID','MUNICIPIOID','MUNICIPIONOMBRE')
                               ->where('ENTIDADFEDERATIVAID','=', $id)
                               ->orderBy('MUNICIPIOID','asc')
                               ->get();
    }

    //***************************************//
    // *** Como se usa el query scope  ******// 
    //***************************************//
    public function scopeName($query, $name)
    {
        if($name)
            return $query->where('NOMBRE_COMPLETO', 'LIKE', "%$name%");
    }

    public function scopeEmail($query, $email)
    {
        if($email)
            return $query->where('OSC_EMAIL', 'LIKE', "%$email%");
    }

    public function scopeBio($query, $bio)
    {
        if($bio)
            return $query->where('OSC_OBJSOC', 'LIKE', "%$bio%");
    } 
    public function scopeNameiap($query, $nameiap)
    {
        if($nameiap) 
            return $query->where('OSC_DESC', 'LIKE', "%$nameiap%");
    } 
 
}