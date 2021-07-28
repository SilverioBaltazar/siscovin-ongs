<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\dependenciasModel;
use App\regPerModel;
use App\regRubroModel;
use App\regFormatosModel;
use App\regDoctosModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportCatDoctos implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID_DOCUMENTO',
            'DOCUMENTO',            
            'ARCHIVO',
            'DEPEN_ID',
            'DEPENDENCIA',
            'ID_FORMATO',
            'FORMATO',
            'ID_PER',
            'PERIODICIDAD',            
            'FREC_ENTREGA_ANUAL',
            'ESTADO',
            'CONTROL',
            'TIPO'
        ];
    }

    public function collection()
    {
         return regDoctosModel::join('JP_CAT_DEPENDENCIAS','JP_CAT_DEPENDENCIAS.DEPEN_ID','=',
                                                            'JP_CAT_DOCUMENTOS.DEPENDENCIA_ID')
                               ->join('JP_CAT_FORMATOS'    ,'JP_CAT_FORMATOS.FORMATO_ID','=',
                                                            'JP_CAT_DOCUMENTOS.FORMATO_ID')
                               ->join('JP_CAT_PERIODICIDAD','JP_CAT_PERIODICIDAD.PER_ID','=',
                                                            'JP_CAT_DOCUMENTOS.PER_ID')                               
                ->select('JP_CAT_DOCUMENTOS.DOC_ID','JP_CAT_DOCUMENTOS.DOC_DESC','JP_CAT_DOCUMENTOS.DOC_FILE',
                         'JP_CAT_DOCUMENTOS.DEPENDENCIA_ID','JP_CAT_DEPENDENCIAS.DEPEN_DESC',
                         'JP_CAT_DOCUMENTOS.FORMATO_ID'    ,'JP_CAT_FORMATOS.FORMATO_DESC',
                         'JP_CAT_DOCUMENTOS.PER_ID'        ,'JP_CAT_PERIODICIDAD.PER_DESC','JP_CAT_DOCUMENTOS.PER_FREC',
                         'JP_CAT_DOCUMENTOS.DOC_STATUS','JP_CAT_DOCUMENTOS.DOC_STATUS2','JP_CAT_DOCUMENTOS.DOC_STATUS3')
                ->orderBy('JP_CAT_DOCUMENTOS.DOC_ID','DESC')
                ->get();                               
    }
}
