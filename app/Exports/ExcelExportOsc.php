<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regOscModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportOsc implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'OSC_ID',
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
            'FIGJURIDICA_ID',
            'FIGURA_JURIDICA',            
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
            'OBJETO_SOCIAL_P1',
            'OBJETO_SOCIAL_P2',
            'FECHA_CERTIFICACION',
            'FECHA_REGISTRO',
            'SITUACION_INM',
            //'VIGENCIA',
            'STATUS'            
        ];
    }

    public function collection()
    {
       // return regOscModel::join('ONG_CAT_MUNICIPIOS_SEDESEM',[['ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
       //                                                    ['ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','ONGS.MUNICIPIO_ID']])
       //                    ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
        return regOscModel::join(  'ONG_CAT_MUNICIPIOS_SEDESEM',[['ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',
                                                                  'ONGS.ENTIDADFEDERATIVA_ID'],
                                                                [ 'ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=',
                                                                  'ONGS.MUNICIPIO_ID']]) 
                          ->join(   'ONG_CAT_ENTIDADES_FED'    ,  'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                  'ONGS.ENTIDADFEDERATIVA_ID')
                          ->join(   'ONG_CAT_RUBROS'        ,'ONG_CAT_RUBROS.RUBRO_ID'           ,'=','ONGS.RUBRO_ID')
                          ->join(   'ONG_CAT_FIGJURIDICA'   ,'ONG_CAT_FIGJURIDICA.FIGJURIDICA_ID','=','ONGS.FIGJURIDICA_ID')                          
                          ->join(   'ONG_CAT_INMUEBLES_EDO' ,'ONG_CAT_INMUEBLES_EDO.INM_ID'      ,'=','ONGS.INM_ID')
                          //->join(   'ONG_CAT_PERIODOS_ANIOS','ONG_CAT_PERIODOS_ANIOS.PERIODO_ID' ,'=','ONGS.ANIO_ID')
                          ->select( 'ONGS.OSC_ID'           ,'ONGS.OSC_DESC', 
                                    'ONGS.OSC_DOM1'         ,'ONGS.OSC_DOM2',
                                    'ONGS.OSC_DOM3'         ,'ONGS.ENTIDADFEDERATIVA_ID',
                                    'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                    'ONGS.MUNICIPIO_ID'     ,'ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE',         
                                    'ONGS.RUBRO_ID'         ,'ONG_CAT_RUBROS.RUBRO_DESC', 
                                    'ONGS.FIGJURIDICA_ID'   ,'ONG_CAT_FIGJURIDICA.FIGJURIDICA_DESC',                                     
                                    'ONGS.OSC_REGCONS'      ,'ONGS.OSC_RFC', 
                                    'ONGS.OSC_CP'           ,'ONGS.OSC_FECCONS2',     
                                    'ONGS.OSC_TELEFONO'     ,'ONGS.OSC_EMAIL',
                                    'ONGS.OSC_SWEB'         ,'ONGS.OSC_PRES',         
                                    'ONGS.OSC_REPLEGAL'     ,'ONGS.OSC_SRIO', 
                                    'ONGS.OSC_TESORERO'     ,
                                    'ONGS.OSC_OBJSOC_1'     ,'ONGS.OSC_OBJSOC_2',        
                                    'ONGS.OSC_FECCERTIFIC'  ,'ONGS.OSC_FECREG',
                                    'ONG_CAT_INMUEBLES_EDO.INM_DESC',
                                    //'ONG_CAT_PERIODOS_ANIOS.PERIODO_DESC',
                                    'ONGS.OSC_STATUS')
                          ->orderBy('ONGS.OSC_ID','ASC')
                          ->get();                               
    }
}
