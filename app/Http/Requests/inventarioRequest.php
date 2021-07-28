<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class inventarioRequest extends FormRequest
{
    public function messages()
    { 
        return [
            'periodo_id.required'    => 'Seleccionar el periodo',
            'osc_id.required'        => 'Seleccionar la OSC',
            'periodo_id1.required'   => 'Seleccionar año de adqusición del arctivo fijo',
            'mes_id1.required'       => 'Seleccionar mes de adqusición del arctivo fijo', 
            'dia_id1.required'       => 'Seleccionar día de adqusición del arctivo fijo', 
            //'activo_id.required'   => 'Clave del activo fijo es numérica y es obligatorio',
            //'activo_id.numeric'    => 'Clave del activo fijo deberá ser numérica',
            'activo_desc.min'        => 'El nombre del activo fijo es de mínimo 1 carácteres.',
            'activo_desc.max'        => 'El nombre del activo fijo es de máximo 500 carácteres.',
            'activo_desc.required'   => 'El nombre del activo fijo es obligatorio.',
            'inventario_doc.min'     => 'Factura o recibo de donación es de mínimo 1 carácteres.',
            'inventario_doc.max'     => 'Factura o recibo de donación es de máximo 100 carácteres.',
            'inventario_doc.required'=> 'Factura o recibo de donación es obligatorio.',
            'activo_valor.required'  => 'Valor o costo del activo fijo es obligatorio.',
            'condicion_id.required'  => 'Seleccionar la condición del arctivo fijo'
            //'trx_desc.regex'       => 'El nombre de la función contiene caracteres inválidos.'
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
            'periodo_id'    => 'required',
            'osc_id'        => 'required',
            'periodo_id1'   => 'required',
            'mes_id1'       => 'required', 
            'dia_id1'       => 'required', 
            //'activo_id'   => 'required|numeric',            
            'activo_desc'   => 'required|min:1|max:500',
            'inventario_doc'=> 'required|min:1|max:100', 
            'activo_valor'  => 'required',
            'condicion_id'  => 'required'
            //'trx_desc'    => 'min:1|max:100|required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i'
        ];
    }
}
