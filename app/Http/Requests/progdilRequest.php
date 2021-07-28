<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class progdilRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'      => 'El periodo fiscal es obligatorio.',
            'mes_id.required'          => 'El mes es obligatorio.',
            'dia_id.requered'          => 'El dia es obligatorio.',            
            'hora_id.requered'         => 'La hora es obligatoria.',            
            'iap_id.required'          => 'Id de la IAP es obligatorio.',
            'entidad_id.required'      => 'Entidad es obligatoria.',
            //'visita_contacto.min'      => 'El contacto de la IAP es de mínimo 1 caracter.',
            //'visita_contacto.max'      => 'El contacto de la IAP es de máximo 100 caracteres.',
            //'visita_contacto.required' => 'El contacto de la IAP es obligatorio.',
            'visita_dom.min'           => 'El domicilio de la IAP es de mínimo 1 caracter.',
            'visita_dom.max'           => 'El domicilio de la IAP es de máximo 80 caracteres.',
            'visita_dom.required'      => 'El domicilio de la IAP es obligatorio.',      
            //'visita_tel.min'           => 'El teléfono de la IAP es de mínimo 1 caracter.',
            //'visita_tel.max'           => 'El teléfono de la IAP es de máximo 60 caracteres.',
            //'visita_tel.required'      => 'El teléfono de la IAP es obligatorio.',                        
            'visita_obj.min'           => 'El objetivo de la visita es de mínimo 1 caracter.',
            'visita_obj.max'           => 'El objetivo de la visita es de máximo 4000 caracteres.',
            'visita_obj.required'      => 'El objetivo de la visita es obligatorio.', 
            'visita_spub.min'          => 'El servidor público que programo visita es de mínimo 1 caracter.',
            'visita_spub.max'          => 'El servidor público que programo visita es de máximo 80 caracteres.',
            'visita_spub.required'     => 'El servidor público que programo visita es obligatorio.',
            'visita_spub2.min'         => 'Personal programado en la diligencia es de mínimo 1 caracter.',
            'visita_spub2.max'         => 'Personal programado en la diligencia es de máximo 200 caracteres.',
            'visita_spub2.required'    => 'Personal programado en la diligencia es obligatorio.',
            'visita_auditor4.min'      => 'El secretario ejecutivo del JAPEM es de mínimo 1 caracter.',
            'visita_auditor4.max'      => 'El secretario ejecutivo del JAPEM es de máximo 80 caracteres.',
            'visita_auditor4.required' => 'El secretario ejecutivo del JAPEM es obligatorio.'
            //'iap_foto1.required' => 'La imagen es obligatoria'
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
            //'iap_desc.'    => 'required|min:1|max:100',
            'iap_id'         => 'required',
            'periodo_id'     => 'required',
            'mes_id'         => 'required',
            'dia_id'         => 'required',            
            'hora_id'        => 'required',                        
            'entidad_id'     => 'required',                        
            //'visita_contacto'=> 'required|min:1|max:80',
            'visita_dom'     => 'required|min:1|max:100',
            //'visita_tel'     => 'required|min:1|max:60',
            'visita_obj'     => 'required|min:1|max:2000',
            'visita_spub'    => 'required|min:1|max:80',
            'visita_spub2'   => 'required|min:1|max:200',
            'visita_auditor4'=> 'required|min:1|max:80'
            //'accion'        => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'        => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
