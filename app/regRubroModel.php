<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regRubroModel extends Model
{
    protected $table      = "ONG_CAT_RUBROS";
    protected $primaryKey = 'RUBRO_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'RUBRO_ID',        
        'RUBRO_DESC',
        'RUBRO_STATUS', //S ACTIVO      N INACTIVO
        'RUBRO_FECREG'
    ];
}