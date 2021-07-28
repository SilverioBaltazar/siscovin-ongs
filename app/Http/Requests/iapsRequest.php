<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class iapsRequest extends FormRequest
{
    public function messages()
    {
        return [
            //'iap_desc.required'   => 'El nombre de la ONG es obligatorio.',
            'iap_desc.min'          => 'El nombre de la ONG es de mínimo 1 caracter.',
            'iap_desc.max'          => 'El nombre de la ONG es de máximo 150 caracteres.',
            'iap_dom1.required'     => 'El domicilio legal es obligatorio.',
            'iap_dom1.min'          => 'El domicilio legal es de mínimo 1 caracter.',
            'iap_dom1.max'          => 'El domicilio legal es de máximo 150 caracteres.',
            //'iap_calle.required'  => 'La calle es obligatoria.',
            //'iap_calle.min'       => 'La calle es de mínimo 1 caracter.',
            //'iap_calle.max'       => 'La calle es de máximo 100 caracteres.',            
            //'iap_num.required'    => 'El número exterior y/o interior es obligatorio.',
            //'iap_num.min'         => 'El número exterior y/o interior es de mínimo 1 carater.',
            //'iap_num.max'         => 'El número exterior y/o interior es de máximo 30 carateres.',
            //'iap_colonia.required'=> 'La colonia es obligatoria.',
            //'iap_colonia.min'     => 'La colonia es de mínimo 1 caracter.',
            //'iap_colonia.max'     => 'La colonia es de máximo 100 caracteres.',
            'entidadfederativa_id.required'=> 'La entidad federativa es obligatoria.',
            'municipio_id.required' => 'El municipio es obligatorio.',            
            'rubro_id.requered'     => 'El rubro es obligatorio.',
            'figurajuridica_id.requered'=> 'La figura jurídica es obligatoria.',
            'iap_regcons.required'  => 'El registro de constitución es obligatorio.',
            'iap_regcons.min'       => 'El registro de constitución es de mínimo 1 caracter.',
            'iap_regcons.max'       => 'El registro de constitución es de máximo 50 caracteres.',
            //'iap_rfc.required'    => 'El RFC es obligatorio.',
            //'iap_rfc.min'         => 'El RFC es de mínimo 3 caracteres.',
            //'iap_rfc.max'         => 'El RFC es de máximo 18 caracteres',
            //'iap_cp.required'     => 'El Código postal es obligatorio.',
            //'iap_cp.min'          => 'El Código postal es de mínimo 5 caracteres.',
            //'iap_cp.max'          => 'El Código postal es de máximo 5 caracteres.',
            //'iap_cp.numeric'      => 'El Código postal debe ser numerico.',            
            //'iap_feccons.requered' => 'La fecha de constitución es obligatoria dd/mm/aaaa.',
            'inm_id.required'       => 'Estado del inmueble es obligatorio.',            
            'anio_id.requered'      => 'La vigencia en años es obligatoria.',
            //'iap_fvp.requered'    => 'La vigencia fecha de vencimiento es obligatoria dd/mm/aaaa.',            
            //'iap_telefono.required'=> 'El teléfono es obligatorio y digitar soló numeros preferentemente.',            
            //'iap_telefono.min'    => 'El teléfono es de mínimo 1 caracteres númericos preferentemente.',
            //'iap_telefono.max'    => 'El teléfono es de máximo 60 caracteres numéricos prefentemente.',
            //'iap_email.required'  => 'El correo eléctronico es obligatorio.',
            //'iap_email.min'       => 'El correo eléctronico es de mínimo 1 caracter.',
            //'iap_email.max'       => 'El correo eléctronico es de máximo 150 caracteres.',
            //'iap_pres.required'   => 'El nombre del presidente es obligatorio.',
            //'iap_pres.min'        => 'El nombre del presidente es de mínimo 1 caracter.',
            //'iap_pres.max'        => 'El nombre del presidente es de máximo 80 caracteres.',
            //'iap_replegal.required' => 'El nombre del representante es obligatorio.',
            //'iap_replegal.min'    => 'El nombre del representante es de mínimo 1 caracter.',
            //'iap_replegal.max'    => 'El nombre del representante es de máximo 150 caracteres.',
            //'iap_srio.required'   => 'El nombre del secretario es obligatorio.',
            //'iap_srio.min'        => 'El nombre del secretario es de mínimo 1 caracter.',
            //'iap_srio.max'        => 'El nombre del secretario es de máximo 80 caracteres.',
            //'iap_tesorero.required' => 'El nombre del tesorero es obligatorio.',
            //'iap_tesorero.min'    => 'El nombre del tesorero es de mínimo 1 caracter.',
            //'iap_tesorero.max'    => 'El nombre del tesorero es de máximo 80 caracteres.'
            'iap_objsoc.required'   => 'Objeto social es obligatorio.',
            'iap_objsoc.min'        => 'Objeto social es de mínimo 1 carácter.',
            'iap_objsoc.max'        => 'Objeto social es de máximo 800 carácteres.'            
            //'iap_status.required' => 'El estado de la ONGS es obligatorio.'
            //'iap_foto1.required'  => 'La imagen es obligatoria'
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'iap_desc.'        => 'required|min:1|max:150',
            //'iap_calle'      => 'required|min:1|max:100',
            //'iap_num'        => 'required|min:1|max:30',
            'iap_dom1'         => 'required|min:1|max:150',
            //'iap_colonia'    => 'required|min:1|max:100',
            'entidadfederativa_id' => 'required',
            'municipio_id'     => 'required',            
            'rubro_id'         => 'required',
            'iap_regcons'      => 'required|min:1|max:50',
            //'iap_rfc'        => 'required|min:18|max:18',
            //'iap_cp'         => 'required|numeric|min:5|min:5',            
            //'iap_feccons'    => 'required',
            'anio_id'          => 'required',            
            'inm_id'           => 'required',
            'figurajuridica_id'=> 'required',
            //'iap_telefono'   => 'required|min:1|max:60',
            //'iap_email'      => 'required|email|min:1|max:60',
            //'iap_pres'       => 'required|min:1|max:80',
            //'iap_replegal'   => 'required|min:1|max:80',
            //'iap_srio'       => 'required|min:1|max:80',
            //'iap_tesorero'   => 'required|min:1|max:80'
            //'iap_status'     => 'required'
            //'iap_foto1'      => 'required|image',
            //'iap_foto2'      => 'required|image'
            'iap_objsoc'       => 'required|min:1|max:800'
            //'accion'         => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'         => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc'     => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
