<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regFuncionModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportCatFunciones implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID_PROCESO',
            'PROCESO',            
            'ID_FUNCION',
            'FUNCION',
            'ESTADO',
            'FECHA_REG'
        ];
    }

    public function collection()
    {
         return regfuncionModel::join('ONG_CAT_PROCESOS','ONG_CAT_PROCESOS.PROCESO_ID','=','ONG_CAT_FUNCIONES.PROCESO_ID')
                             ->select('ONG_CAT_FUNCIONES.PROCESO_ID','ONG_CAT_PROCESOS.PROCESO_DESC','ONG_CAT_FUNCIONES.FUNCION_ID','ONG_CAT_FUNCIONES.FUNCION_DESC','ONG_CAT_FUNCIONES.FUNCION_STATUS','ONG_CAT_FUNCIONES.FUNCION_FECREG')
                            ->orderBy('ONG_CAT_FUNCIONES.PROCESO_ID','ASC')
                            ->orderBy('ONG_CAT_FUNCIONES.FUNCION_ID','ASC')
                            ->get();                               
    }
}
