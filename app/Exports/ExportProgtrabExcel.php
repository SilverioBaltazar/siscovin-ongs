<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regProgtrabModel;
use App\regProgdtrabModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportProgtrabExcel implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'FOLIO',
            'PERIODO',
            'FECHA_ELAB',
            'OSC_ID',            
            'OSC',            
            'RESPONSABLE',
            'PROGRAMA',
            'ACTIVIDAD',
            'OBJETIVO',
            'UNID_MEDIDA',
            'ELABORO',
            'AUTORIZO',
            'OBSERVACIONES',
            'ESTADO',
            'FECHA_REGISTRO',            
            'ENE',
            'FEB',
            'MAR',
            'ABR',
            'MAY',            
            'JUN',
            'JUL',
            'AGO',
            'SEP',
            'OCT',
            'NOV',            
            'DIC',
            'TOTAL_META_PROGRAMADA'
        ];
    }

    public function collection()
    {
        $arbol_id     = session()->get('arbol_id');  
        //$id           = session()->get('sfolio');        
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            //ONG_PROGRAMA_ETRABAJO on ONG_PROGRAMA_ETRABAJO.FOLIO   = ONG_PROGRAMA_DTRABAJO.FOLIO 
            //            inner join ONG_IAPS              on ONG_IAPS.OSC_ID               = ONG_PROGRAMA_ETRABAJO.OSC_ID 
            //            inner join ONG_CAT_UNID_MEDIDA   on ONG_CAT_UNID_MEDIDA.UMEDIDA_ID= ONG_PROGRAMA_DTRABAJO.UMEDIDA_ID
            return regProgdtrabModel::join('ONG_PROGRAMA_ETRABAJO','ONG_PROGRAMA_ETRABAJO.FOLIO','=',
                                                                   'ONG_PROGRAMA_DTRABAJO.FOLIO')
                   ->join(  'ONGS'                ,'ONGS.OSC_ID'                   ,'=','ONG_PROGRAMA_ETRABAJO.OSC_ID')
                   ->join(  'ONG_CAT_UNID_MEDIDA' ,'ONG_CAT_UNID_MEDIDA.UMEDIDA_ID','=','ONG_PROGRAMA_DTRABAJO.UMEDIDA_ID')
                   ->select('ONG_PROGRAMA_ETRABAJO.FOLIO', 
                            'ONG_PROGRAMA_ETRABAJO.PERIODO_ID', 
                            'ONG_PROGRAMA_ETRABAJO.FECHA_ELAB2', 
                            'ONGS.OSC_ID',               
                            'ONGS.OSC_DESC',        
                            'ONG_PROGRAMA_ETRABAJO.RESPONSABLE', 
                            'ONG_PROGRAMA_DTRABAJO.PROGRAMA_DESC', 
                            'ONG_PROGRAMA_DTRABAJO.ACTIVIDAD_DESC', 
                            'ONG_PROGRAMA_DTRABAJO.OBJETIVO_DESC',
                            'ONG_CAT_UNID_MEDIDA.UMEDIDA_DESC', 
                            'ONG_PROGRAMA_ETRABAJO.ELABORO', 
                            'ONG_PROGRAMA_ETRABAJO.AUTORIZO', 
                            'ONG_PROGRAMA_ETRABAJO.OBS_1', 
                            'ONG_PROGRAMA_ETRABAJO.STATUS_1', 
                            'ONG_PROGRAMA_ETRABAJO.FECREG',                                   
                            'ONG_PROGRAMA_DTRABAJO.MESP_01', 'ONG_PROGRAMA_DTRABAJO.MESP_02', 'ONG_PROGRAMA_DTRABAJO.MESP_03', 
                            'ONG_PROGRAMA_DTRABAJO.MESP_04', 'ONG_PROGRAMA_DTRABAJO.MESP_05', 'ONG_PROGRAMA_DTRABAJO.MESP_06', 
                            'ONG_PROGRAMA_DTRABAJO.MESP_07', 'ONG_PROGRAMA_DTRABAJO.MESP_08', 'ONG_PROGRAMA_DTRABAJO.MESP_09', 
                            'ONG_PROGRAMA_DTRABAJO.MESP_10', 'ONG_PROGRAMA_DTRABAJO.MESP_11', 'ONG_PROGRAMA_DTRABAJO.MESP_12' 
                            )
                   ->selectRaw('(ONG_PROGRAMA_DTRABAJO.MESP_01+ONG_PROGRAMA_DTRABAJO.MESP_02+ONG_PROGRAMA_DTRABAJO.MESP_03+
                                 ONG_PROGRAMA_DTRABAJO.MESP_04+ONG_PROGRAMA_DTRABAJO.MESP_05+ONG_PROGRAMA_DTRABAJO.MESP_06+
                                 ONG_PROGRAMA_DTRABAJO.MESP_07+ONG_PROGRAMA_DTRABAJO.MESP_08+ONG_PROGRAMA_DTRABAJO.MESP_09+
                                 ONG_PROGRAMA_DTRABAJO.MESP_10+ONG_PROGRAMA_DTRABAJO.MESP_11+ONG_PROGRAMA_DTRABAJO.MESP_12)
                                 META_PROGRAMADA')
                   ->where(  'ONG_PROGRAMA_ETRABAJO.FOLIO'     ,$id)
                   ->orderBy('ONG_PROGRAMA_ETRABAJO.PERIODO_ID','ASC')                   
                   ->orderBy('ONG_PROGRAMA_ETRABAJO.FOLIO'     ,'ASC')
                   ->get();                               
        }else{
            return regProgdtrabModel::join('ONG_PROGRAMA_ETRABAJO','ONG_PROGRAMA_ETRABAJO.FOLIO','=',
                                                                   'ONG_PROGRAMA_DTRABAJO.FOLIO')
                   ->join(  'ONGS'                ,'ONGS.OSC_ID'                   ,'=','ONG_PROGRAMA_ETRABAJO.OSC_ID')
                   ->join(  'ONG_CAT_UNID_MEDIDA' ,'ONG_CAT_UNID_MEDIDA.UMEDIDA_ID','=','ONG_PROGRAMA_DTRABAJO.UMEDIDA_ID')
                   ->select('ONG_PROGRAMA_ETRABAJO.FOLIO', 
                            'ONG_PROGRAMA_ETRABAJO.PERIODO_ID', 
                            'ONG_PROGRAMA_ETRABAJO.FECHA_ELAB2', 
                            'ONGS.OSC_ID',               
                            'ONGS.OSC_DESC',        
                            'ONG_PROGRAMA_ETRABAJO.RESPONSABLE', 
                            'ONG_PROGRAMA_DTRABAJO.PROGRAMA_DESC', 
                            'ONG_PROGRAMA_DTRABAJO.ACTIVIDAD_DESC', 
                            'ONG_PROGRAMA_DTRABAJO.OBJETIVO_DESC',
                            'ONG_CAT_UNID_MEDIDA.UMEDIDA_DESC', 
                            'ONG_PROGRAMA_ETRABAJO.ELABORO', 
                            'ONG_PROGRAMA_ETRABAJO.AUTORIZO', 
                            'ONG_PROGRAMA_ETRABAJO.OBS_1', 
                            'ONG_PROGRAMA_ETRABAJO.STATUS_1', 
                            'ONG_PROGRAMA_ETRABAJO.FECREG',                         
                            'ONG_PROGRAMA_DTRABAJO.MESP_01', 'ONG_PROGRAMA_DTRABAJO.MESP_02', 'ONG_PROGRAMA_DTRABAJO.MESP_03', 
                            'ONG_PROGRAMA_DTRABAJO.MESP_04', 'ONG_PROGRAMA_DTRABAJO.MESP_05', 'ONG_PROGRAMA_DTRABAJO.MESP_06', 
                            'ONG_PROGRAMA_DTRABAJO.MESP_07', 'ONG_PROGRAMA_DTRABAJO.MESP_08', 'ONG_PROGRAMA_DTRABAJO.MESP_09', 
                            'ONG_PROGRAMA_DTRABAJO.MESP_10', 'ONG_PROGRAMA_DTRABAJO.MESP_11', 'ONG_PROGRAMA_DTRABAJO.MESP_12' 
                            )
                   ->selectRaw('(ONG_PROGRAMA_DTRABAJO.MESP_01+ONG_PROGRAMA_DTRABAJO.MESP_02+ONG_PROGRAMA_DTRABAJO.MESP_03+
                                 ONG_PROGRAMA_DTRABAJO.MESP_04+ONG_PROGRAMA_DTRABAJO.MESP_05+ONG_PROGRAMA_DTRABAJO.MESP_06+
                                 ONG_PROGRAMA_DTRABAJO.MESP_07+ONG_PROGRAMA_DTRABAJO.MESP_08+ONG_PROGRAMA_DTRABAJO.MESP_09+
                                 ONG_PROGRAMA_DTRABAJO.MESP_10+ONG_PROGRAMA_DTRABAJO.MESP_11+ONG_PROGRAMA_DTRABAJO.MESP_12)
                                 META_PROGRAMADA')
                   ->where(['ONG_PROGRAMA_ETRABAJO.FOLIO' => $id, 'ONG_PROGRAMA_ETRABAJO.OSC_ID' => $arbol_id])
                   //->where(  'ONG_PROGRAMA_ETRABAJO.OSC_ID',$arbol_id)
                   ->orderBy('ONG_PROGRAMA_ETRABAJO.PERIODO_ID','ASC')
                   ->orderBy('ONG_PROGRAMA_ETRABAJO.FOLIO'     ,'ASC')
                   ->get();               
        }                            
    }
}
