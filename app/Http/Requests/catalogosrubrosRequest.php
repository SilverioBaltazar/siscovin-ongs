<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class catalogosrubrosRequest extends FormRequest
{
    public function messages()
    {
        return [
            'rubro_id.required' => 'La clave del rubro social es obligatoria.',
            'rubro_desc.required' => 'El nombre del rubro social es obligatorio.',
            'rubro_desc.min' => 'El nombre del rubro social es de mínimo 1 caracter.',
            'rubro_desc.max' => 'El nombre del rubro social es de máximo 80 caracteres.',
            'rubro_desc.regex' => 'El nombre del rubro social contiene caracteres inválidos.'
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
            'rubro_desc' =>  'min:1|max:80|required'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
