<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regIapJuridicoModel extends Model
{
    protected $table      = "JP_REQUISITOS_DOC";
    protected $primaryKey = 'IAP_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
    'IAP_FOLIO',
    'IAP_ID',
    'PERIODO_ID',
    'DOC_ID1',
    'FORMATO_ID1',
    'IAP_D1',
    'PER_ID1',
    'NUM_ID1',
    'IAP_EDO1',
    'DOC_ID2',
    'FORMATO_ID2',
    'IAP_D2',
    'PER_ID2',
    'NUM_ID2',
    'IAP_EDO2',
    'DOC_ID3',
    'FORMATO_ID3',
    'IAP_D3',
    'PER_ID3',
    'NUM_ID3',
    'IAP_EDO3',
    'DOC_ID4',
    'FORMATO_ID4',
    'IAP_D4',
    'PER_ID4',
    'NUM_ID4',
    'IAP_EDO4',
    'DOC_ID5',
    'FORMATO_ID5',
    'IAP_D5',
    'PER_ID5',
    'NUM_ID5',
    'IAP_EDO5',
    'DOC_ID6',
    'FORMATO_ID6',
    'IAP_D6',
    'PER_ID6',
    'NUM_ID6',
    'IAP_EDO6',
    'DOC_ID7',
    'FORMATO_ID7',
    'IAP_D7',
    'PER_ID7',
    'NUM_ID7',
    'IAP_EDO7',
    'DOC_ID8',
    'FORMATO_ID8',
    'IAP_D8',
    'PER_ID8',
    'NUM_ID8',
    'IAP_EDO8',
    'DOC_ID9',
    'FORMATO_ID9',
    'IAP_D9',
    'PER_ID9',
    'NUM_ID9',
    'IAP_EDO9',
    'DOC_ID10',
    'FORMATO_ID10',
    'IAP_D10',
    'PER_ID10',
    'NUM_ID10',
    'IAP_EDO10',
    'DOC_ID11',
    'FORMATO_ID11',
    'IAP_D11',
    'PER_ID11',
    'NUM_ID11',
    'IAP_EDO11',
    'DOC_ID12',
    'FORMATO_ID12',
    'IAP_D12',
    'PER_ID12',
    'NUM_ID12',
    'IAP_EDO12',
    'DOC_ID13',
    'FORMATO_ID13',
    'IAP_D13',
    'PER_ID13',
    'NUM_ID13',
    'IAP_EDO13',
    'DOC_ID14',
    'FORMATO_ID14',
    'IAP_D14',
    'PER_ID14',
    'NUM_ID14',
    'IAP_EDO14',
    'DOC_ID15',
    'FORMATO_ID15',
    'IAP_D15',
    'PER_ID15',
    'NUM_ID15',
    'IAP_EDO15',
    'PREG_001',
    'PREG_002',
    'PREG_003',
    'PREG_004',
    'PREG_005',
    'PREG_006',
    'PREG_007',
    'PREG_008',
    'PREG_009',
    'PREG_010',
    'PREG_011',
    'PREG_012',
    'PREG_013',
    'PREG_014',
    'PREG_015',
    'PREG_016',
    'PREG_017',
    'PREG_018',
    'PREG_019',
    'PREG_020',
    'PREG_021',
    'PREG_022',
    'PREG_023',
    'PREG_024',
    'PREG_025',
    'IAP_STATUS',
    'FECREG',
    'IP',
    'LOGIN',
    'FECHA_M',
    'IP_M',
    'LOGIN_M'     
    ];

}