<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class iapsjuridico1Request extends FormRequest
{
    public function messages()
    {
        return [
            //'iap_desc.required' => 'El nombre de la IAP es obligatorio.',
            //'iap_rpp.required' => 'Seleccionar si está registrada en el registro público de la propiedad.',
            //'anio_id.required' => 'Seleccionar la vigencia en años del patronato.',
            //'inm_id.required'  => 'Seleccionar clave del estado del inmueble.', 
            'iap_act_const.required' => 'Archivo de Acta Constituiva de la IAP en formato PDF es obligatorio'
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
            //'iap_rpp'  => 'required',          
            //'anio_id' => 'required',
            'iap_act_const' => 'required',
            'iap_act_const' => 'sometimes|mimetypes:application/pdf|max:2048',
            'iap_act_const' => 'sometimes|mimetypes:pdf|max:2048',
            'iap_act_const' => 'sometimes|mimes:application/pdf|max:2048',
            'iap_act_const' => 'sometimes|mimes:pdf|max:2048'
            //'iap_foto1'    => 'required|image',
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
