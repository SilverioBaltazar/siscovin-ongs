<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regIapModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportCatIaps implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'IAP_ID',
            'NOMBRE',
            'DOMICILIO_LEGAL',
            'DOMICILIO_2',
            'DOMICILIO_3',
            'ENTIDADFEDERATIVA_ID',
            'ENTIDAD_FEDERATIVA',
            'MUNICIPIO_ID',
            'MUNICIPIO',
            'RUBRO_ID',
            'RUBRO',
            'REGISTRO_CONSTITUCION',
            'RFC',
            'CP',
            'FECHA_CONSTITUCION',
            'TELEFONO',
            'EMAIL',
            'SITIO_WEB',
            'PRESIDENTE',
            'REPRESENTANTE_LEGAL',
            'SRIO',
            'TESORERO',
            'OBJETO_SOCIAL',
            'STATUS',
            'FECHA_CERTIFICACION',
            'FECHA_REGISTRO'
        ];
    }

    public function collection()
    {
        return regIapModel::join('ONG_CAT_MUNICIPIOS_SEDESEM',[['ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',
                                                               'ONGS.ENTIDADFEDERATIVA_ID'],
                                                              ['ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=',
                                                               'ONGS.MUNICIPIO_ID']]) 
                          ->join('ONG_CAT_ENTIDADES_FED'     ,  'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                               'ONGS.ENTIDADFEDERATIVA_ID')
                          ->join('ONG_CAT_RUBROS','ONG_CAT_RUBROS.RUBRO_ID','=','ONGS.RUBRO_ID')
                          ->select('ONGS.IAP_ID',  'ONGS.IAP_DESC', 'ONGS.IAP_DOM1',
                            'ONGS.IAP_DOM2','ONGS.IAP_DOM3',     
                            'ONGS.ENTIDADFEDERATIVA_ID','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                            'ONGS.MUNICIPIO_ID','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE',         
                            'ONGS.RUBRO_ID',    'ONG_CAT_RUBROS.RUBRO_DESC', 'ONGS.IAP_REGCONS', 'ONGS.IAP_RFC', 
                            'ONGS.IAP_CP',      'ONGS.IAP_FECCONS2',     'ONGS.IAP_TELEFONO','ONGS.IAP_EMAIL',
                            'ONGS.IAP_SWEB',    'ONGS.IAP_PRES',         'ONGS.IAP_REPLEGAL','ONGS.IAP_SRIO', 
                            'ONGS.IAP_TESORERO','ONGS.IAP_OBJSOC',       'ONGS.IAP_STATUS',  
                            'ONGS.IAP_FECCERTIFIC','ONGS.IAP_FECREG')
                          ->orderBy('ONGS.IAP_ID','ASC')
                          ->get();                               
    }
}
