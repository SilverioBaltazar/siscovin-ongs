<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regBancosModel extends Model
{
    protected $table      = "JP_CAT_BANCOS";
    protected $primaryKey = 'BANCO_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'BANCO_ID',
        'BANCO_DESC',
        'BANCO_STATUS', //S ACTIVO      N INACTIVO
        'FECREG'
    ];
}