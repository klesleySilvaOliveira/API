<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;
    protected $fillable = ['nome_cidade', 'estado'];
    public function rules(){
        return [
            'nome_cidade' => 'required|unique:cidades,nome_cidade,'.$this->id.'|string',
            'estado' => 'required|string'
        ];
    }

    public function feedback(){
        return [
            'required' => 'o campo :attribute é obrigatório',
            'nome_cidade.unique' => 'O nome informado já existe',
            'string' => 'O campo :attribute informado(a) deve ser um texto'
        ];
    }
}
