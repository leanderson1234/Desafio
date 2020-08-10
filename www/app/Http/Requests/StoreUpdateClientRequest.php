<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateClientRequest extends FormRequest
{
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
        //Nome Empresa, CNPJ, Telefone, Nome do Responsável, Email e Endereço
        $id = $this->segment(2);
        
        return [
            'empresa'       => 'required|min:3',
            'cnpj'          => "required|unique:client,cnpj,{$id},id",
            'telefone'      => 'required',
            'responsavel'   => 'required',
            'email'         => "required|email:rfc|unique:client,email,{$id},id",
            'cep'           => 'required',
            // 'client_id'     => 'required',
            'isPrimary'     => 'nullable'
        ];
    }
}
