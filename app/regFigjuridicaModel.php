<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFigjuridicaModel extends Model
{
    protected $table      = "ONG_CAT_FIGJURIDICA";
    protected $primaryKey = 'FIGJURIDICA_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'FIGJURIDICA_ID',
        'FIGJURIDICA_DESC',
        'FIGJURIDICA_STATUS',
        'FIGJURIDICA_FECREG'
    ];
}