<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regPreguntasModel extends Model
{
    protected $table = "JP_CAT_PREGUNTAS";
    protected  $primaryKey = 'PREG_ID';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'PREG_ID',
		'PREG_DESC',
		'PREG_STATUS',
		'FECREG'
    ];
}
