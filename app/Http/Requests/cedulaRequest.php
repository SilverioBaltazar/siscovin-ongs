<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cedulaRequest extends FormRequest
{
    public function messages()
    {
        return [
            //'iap_id.required'         => 'IAP es obligatorio.',            
            'periodo_id1.required'    => 'Año de elaboración es obligatorio.',
            'mes_id1.required'        => 'Mes de elaboración es obligatorio.',
            'dia_id1.required'        => 'Dia de elaboración es obligatorio.',
            'sp_nomb.min'             => 'Responsable es de mínimo 1 caracter.',
            'sp_nomb.max'             => 'Responsable es de máximo 80 caracteres.',
            'sp_nomb.required'        => 'Responsable es obligatorio.'
            //'iap_status.required' => 'El estado de la IAPS es obligatorio.'
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
            'periodo_id1'      => 'required',
            'mes_id1'          => 'required',
            'dia_id1'          => 'required',
            'sp_nomb'          => 'required|min:1|max:80'
            //'accion'        => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'        => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
