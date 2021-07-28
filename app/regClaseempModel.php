<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regClaseempModel extends Model
{
    protected $table      = "JP_CAT_CLASES_EMPLEADO";
    protected $primaryKey = 'CLASEEMP_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'CLASEEMP_ID',
		'CLASEEMP_DESC',
		'CLASEEMP_STATUS',
		'CLASEEMP_FECREG'
    ];
}
