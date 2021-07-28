<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class catdoctoRequest extends FormRequest
{
    public function messages()
    {
        return [
            //'doc_id.required'         => 'Seleccionar id del documento.',
            'doc_desc.min'            => 'El nombre del documento es de mínimo 1 caracteres.',
            'doc_desc.max'            => 'El nombre del documento es de máximo 80 caracteres.',
            'doc_desc.required'       => 'El nombre del documento es obligatorio.',
            //'doc_obs.min'           => 'Las observaciones es de mínimo 1 caracteres.',
            //'doc_obs.max'           => 'Las observaciones es de máximo 200 caracteres.',
            //'doc_obs.required'      => 'Las observaciones es obligatoria.',
            'dependencia_id.required' => 'Seleccionar dependencia que requiere el documento',
            'formato_id.required'     => 'Seleccionar el formato del documento.',  
            'per_id.required'         => 'Seleccionar la frecuencia de solicitud del documento.',  
            'rubro_id.required'       => 'Seleccionar el rubro social al que aplica.',
            'doc_status2.required'    => 'Seleccionar el control al que aplica.',
            'doc_status3.required'    => 'Seleccionar el tipo al que aplica.'
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
            'doc_desc'       => 'required|min:1|max:80',
            //'doc_obs'        => 'required|min:1|max:200',
            'dependencia_id' => 'required',
            'formato_id'     => 'required',
            'per_id'         => 'required',
            'rubro_id'       => 'required',
            'doc_status2'    => 'required',
            'doc_status3'    => 'required'
            //'trx_desc' => 'min:1|max:100|required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i'
        ];
    }
}
