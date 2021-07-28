<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regPadronModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPadronExcel implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'FOLIO',
            'OSC',
            'FECHA_INGRESO',
            'APELLIDO_PATERNO',
            'APELLIDO_MATERNO',
            'NOMBRES',
            'FECHA_NACIMIENTO',
            'CURP',
            'SEXO',
            'DOMICILIO',
            'CP',            
            'COLONIA',
            'ENTIDAD_FEDERATIVA',
            'MUNICIPIO',
            'MOTIVO_INGRESO',
            'INTEG_FAMILIA',
            'SERVICIO',
            'CUOTA_RECUP',
            'QUIEN_CANALIZO',
            'STATUS',
            'FECHA_REGISTRO'
        ];
    }

    public function collection()
    {
        $arbol_id     = session()->get('arbol_id');        
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            //return regPadronModel::join('ONG_CAT_MUNICIPIOS_SEDESEM','ONG_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=',
            //                                                        'ONG_METADATO_PADRON.MUNICIPIO_ID') 
            //                ->wherein('ONG_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
            return regPadronModel::join('ONG_CAT_ENTIDADES_FED','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                'ONG_METADATO_PADRON.ENTIDAD_FED_ID')
                            ->join('ONG_CAT_SERVICIOS'  ,'ONG_CAT_SERVICIOS.SERVICIO_ID','=','ONG_METADATO_PADRON.SERVICIO_ID')
                            ->join('ONGS'               ,'ONGS.OCS_ID'                  ,'=','ONG_METADATO_PADRON.OCS_ID')
                            ->select('ONG_METADATO_PADRON.FOLIO',
                                     'ONGS.OCS_DESC'            ,  
                                     'ONG_METADATO_PADRON.FECHA_INGRESO2', 
                                     'ONG_METADATO_PADRON.PRIMER_APELLIDO',
                                     'ONG_METADATO_PADRON.SEGUNDO_APELLIDO',
                                     'ONG_METADATO_PADRON.NOMBRES',
                                     'ONG_METADATO_PADRON.FECHA_NACIMIENTO2',     
                                     'ONG_METADATO_PADRON.CURP',     
                                     'ONG_METADATO_PADRON.SEXO',     
                                     'ONG_METADATO_PADRON.DOMICILIO',     
                                     'ONG_METADATO_PADRON.CP', 
                                     'ONG_METADATO_PADRON.COLONIA',
                                     'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                     'ONG_METADATO_PADRON.LOCALIDAD',         
                                     'ONG_METADATO_PADRON.MOTIVO_ING',
                                     'ONG_METADATO_PADRON.INTEG_FAM', 
                                     'ONG_CAT_SERVICIOS.SERVICIO_DESC', 
                                     'ONG_METADATO_PADRON.CUOTA_RECUP',
                                     'ONG_METADATO_PADRON.QUIEN_CANALIZO', 
                                     'ONG_METADATO_PADRON.STATUS_1',  
                                     'ONG_METADATO_PADRON.FECHA_REG'
                                    )
                            ->orderBy('ONG_METADATO_PADRON.NOMBRE_COMPLETO','ASC')
                            ->get();                               
        }else{
            return regPadronModel::join('ONG_CAT_ENTIDADES_FED','ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID', '=', 
                                                                'ONG_METADATO_PADRON.ENTIDAD_FED_ID')
                            ->join('ONG_CAT_SERVICIOS'  ,'ONG_CAT_SERVICIOS.SERVICIO_ID','=','ONG_METADATO_PADRON.SERVICIO_ID')
                            ->join('ONGS'           ,'ONG.OCS_ID'                       ,'=','ONG_METADATO_PADRON.OCS_ID')
                            ->select('ONG_METADATO_PADRON.FOLIO',
                                     'ONGS.OSC_DESC'        ,  
                                     'ONG_METADATO_PADRON.FECHA_INGRESO2', 
                                     'ONG_METADATO_PADRON.PRIMER_APELLIDO',
                                     'ONG_METADATO_PADRON.SEGUNDO_APELLIDO',
                                     'ONG_METADATO_PADRON.NOMBRES',
                                     'ONG_METADATO_PADRON.FECHA_NACIMIENTO2',     
                                     'ONG_METADATO_PADRON.CURP',     
                                     'ONG_METADATO_PADRON.SEXO',     
                                     'ONG_METADATO_PADRON.DOMICILIO',     
                                     'ONG_METADATO_PADRON.CP', 
                                     'ONG_METADATO_PADRON.COLONIA',
                                     'ONG_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                     'ONG_METADATO_PADRON.LOCALIDAD',          
                                     'ONG_METADATO_PADRON.MOTIVO_ING',
                                     'ONG_METADATO_PADRON.INTEG_FAM', 
                                     'ONG_CAT_SERVICIOS.SERVICIO_DESC', 
                                     'ONG_METADATO_PADRON.CUOTA_RECUP',
                                     'ONG_METADATO_PADRON.QUIEN_CANALIZO', 
                                     'ONG_METADATO_PADRON.STATUS_1',
                                     'ONG_METADATO_PADRON.FECHA_REG'
                                    )
                            ->where('ONG_METADATO_PADRON.OCS_ID',$arbol_id)
                            ->orderBy('ONG_METADATO_PADRON.NOMBRE_COMPLETO','ASC')
                            ->get();               
        }                            
    }
}
