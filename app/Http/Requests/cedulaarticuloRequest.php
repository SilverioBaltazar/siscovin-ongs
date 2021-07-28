<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cedulaarticuloRequest extends FormRequest
{
    public function messages()
    {
        return [
            //'iap_id.required'         => 'IAP es obligatorio.',            
            //'articulo_id.required'    => 'Articulo es obligatorio.'
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
            //'articulo_id'      => 'required'
            //'accion'        => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'        => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
