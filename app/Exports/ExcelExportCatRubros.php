<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regRubroModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportCatRubros implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'RUBRO_SOCIAL',
            'ESTADO',
            'FECHA_REG'
        ];
    }

    public function collection()
    {
        return $regrubro = regRubroModel::select('RUBRO_ID','RUBRO_DESC', 'RUBRO_STATUS','RUBRO_FECREG')
            ->orderBy('RUBRO_ID','desc')->get();                                
    }
}
