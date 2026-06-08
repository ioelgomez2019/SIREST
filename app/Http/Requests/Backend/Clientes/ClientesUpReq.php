<?php

namespace App\Http\Requests\Backend\Clientes;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ClientesUpReq extends FormRequest
{
    //protected $primaryKey = 'idcliente';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $cliente = $this->route('cliente');
        return [
            'nombre_cliente' => 'required',
            'apellido_cliente' => 'required',
            'identificacion_cliente' => ['required',
                        Rule::unique('clientes','identificacion')->ignore($cliente)
                        ],
            //'identificacion_cliente' => ['required', 'unique:clientes,identificacion,'. $cliente->idcliente],
            'password_cliente' => 'sometimes',
            'telefono_cliente' => 'required',
            'email_cliente'  => ['required', 'email',
                            Rule::unique('clientes','email')->ignore($cliente)
                            ],
            'direccionfiscal_cliente' => 'sometimes',
        ];
    }
}
