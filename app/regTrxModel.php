<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regTrxModel extends Model
{
    protected $table      = "ONG_CAT_TRX";
    protected $primaryKey = 'TRX_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'TRX_ID',
        'TRX_DESC',
        'TRX_STATUS', //S ACTIVO      N INACTIVO
        'TRX_FECREG'
    ];
}