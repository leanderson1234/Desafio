<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $table = 'endereco';
    protected $fillable = ['id',
                        'cep',
                        'logradouro',
                        'bairro',
                        'complemento',
                        'numero',
                        'cidade',
                        'estado',
                        'client_id',
                        'isPrimary'];
    public $timestamps = false;
    public function getAll(){
        $result = $this->join('client', 'client.id', '=', 'endereco.client_id')
             ->select('*')
             ->paginate();
            
        return $result;
    }
    public function edit($id){
        return $datas =  $this->join('client', 'client.id', '=', 'endereco.client_id')
        ->where( 'client_id', '=', $id)
        ->select('endereco.id','cep',
        'logradouro',
        'bairro',
        'complemento',
        'numero',
        'cidade',
        'estado',
        'client_id',
        'isPrimary',
        'empresa',
        'cnpj',
        'telefone',
        'responsavel',
        'email')->get();
     
    }
}
