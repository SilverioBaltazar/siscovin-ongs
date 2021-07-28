<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regBalanzaModel extends Model
{
    protected $table      = "JP_EDOS_FINANCIEROS";
    protected $primaryKey = 'EDOFINAN_FOLIO';
    public $timestamps    = false;
    public $incrementing  = false; 
    protected $fillable   = [
        'EDOFINAN_FOLIO',
        'PERIODO_ID',
        'DOC_ID',
        'FORMATO_ID',
        'PER_ID',
        'NUM_ID',
        'IAP_ID',
        'IDS_DREEF',
        'IDS_DREES',
        'IDS_CRECUP',
        'IDS_AGUB',
        'IDS_LDING',
        'EDS_CA',
        'EDS_GA',
        'EDS_CF',
        'REMAN_SEM',
        'ACT_CIRC',
        'ACT_NOCIRC',
        'ACT_NOCIRCINM',
        'PAS_ACP',
        'PAS_ALP',
        'PATRIMONIO',
        'EDOFINAN_FECHA',
        'EDOFINAN_FECHA2',
        'PERIODO_ID1',
        'MES_ID1',
        'DIA_ID1',
        'EDOFINAN_FOTO1',
        'EDOFINAN_FOTO2',
        'EDOFINAN_OBS',
        'EDOFINAN_STATUS',
        'FECREG',
        'IP',
        'LOGIN',
        'FECHA_M',
        'IP_M',
        'LOGIN_M'
    ];
}
