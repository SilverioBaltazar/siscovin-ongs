<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regInmuebleedoModel extends Model
{
    protected $table      = "ONG_CAT_INMUEBLES_EDO";
    protected $primaryKey = 'INM_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'INM_ID',        
        'INM_DESC',
        'INM_STATUS', //S ACTIVO      N INACTIVO
        'INM_FECREG'
    ];
}