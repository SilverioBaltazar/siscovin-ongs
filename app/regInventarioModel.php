<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regInventarioModel extends Model
{
    protected $table      = "ONG_INVENTARIO";
    protected $primaryKey = ['OSC_ID','ACTIVO_ID'];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'ID',
        'OSC_ID',
        'ACTIVO_ID',
        'ACTIVO_DESC',
        'INVENTARIO_FECADQ',
        'INVENTARIO_FECADQ2',
        'INVENTARIO_FECADQ3',
        'PERIODO_ID1',
        'MES_ID1',
        'DIA_ID1',
        'INVENTARIO_DOC',
        'ACTIVO_VALOR',
        'CONDICION_ID',
        'INVENTARIO_OBS',
        'INVENTARIO_STATUS',
        'FECREG',
        'FECREG2',
        'IP',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'LOGIN_M'
    ];
}
