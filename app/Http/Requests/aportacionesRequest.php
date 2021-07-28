<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class aportacionesRequest extends FormRequest
{
    public function messages()
    {
        return [
            //'iap_desc.required' => 'El nombre de la IAP es obligatorio.',
            'periodo_id.required' => 'El periodo es obligatoria.',
            'banco_id.required' => 'El banco es obligatorio.',            
            'mes_id.requered' => 'El mes es obligatorio.',            
            'apor_concepto.required' => 'Concepto de la aportación.',
            'apor_monto.required' => 'Cantidad de la aportacion.',
            'apor_recibe.min' => 'El nombre de la persona que recibe la aportación monetaria de mínimo 1 caracter.',
            'apor_recibe.max' => 'El nombre de la persona que recibe la aportación monetaria es de máximo 80 caracteres.',
            'apor_entrega.min' => 'El nombre de la persona que entrega la aportación monetaria es de mínimo 1 caracter.',
            'apor_entrega.max' => 'El nombre de la persona que entrega la aportación monetaria es de máximo 80 caracteres.'
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
            'periodo_id'   => 'required',
            'banco_id'     => 'required',            
            'mes_id'       => 'required',            
            'apor_concepto'=> 'required|min:1|max:100',
            'apor_monto'   => 'required',
            'apor_entrega' => 'required|min:1|max:100',
            'apor_recibe'  => 'required|min:1|max:100'
            //'accion'        => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'        => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
