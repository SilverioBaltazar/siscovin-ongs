<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regQuestionsModel extends Model
{
    protected $table = "JP_QUESTIONS";
    protected  $primaryKey = 'QUESTION_NO';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'QUESTION_NO',
		'PREG_ID',
		'TIPOP_ID',
		'SECCION_ID',
		'RUBRO_ID',
		'QUESTION_OBS',
		'QUESTION_STATUS',
		'FECREG'
    ];
}
