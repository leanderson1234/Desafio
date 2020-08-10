<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $fillable = ['id',
    'empresa',
    'cnpj',
    'telefone',
    'responsavel',
    'email',
    'cep'];
    public $timestamps = false;
    
    
}
