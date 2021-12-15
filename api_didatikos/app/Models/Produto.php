<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $fillable = ['cod_produto', 'nome_produto', 'valor_produto', 'estoque', 'cidade_id'];

    public function rules(){
        return [
            'cod_produto' => 'required|unique:produtos,cod_produto'.$this->id.'|integer',
            'nome_produto' => 'required|string',
            'valor_produto' => 'required',
            'estoque' => 'required|integer',
            'cidade_id' => 'required|integer|exists:cidades,id'
        ];
    }

    public function feedback(){
        return [
            'required' => 'o campo :attribute é obrigatório',
            'integer' => 'O campo :attribute deve ser um valor inteiro',
            'cod_produto.unique' => 'O código informado já existe',
            'nome_produto.string' => 'O nome do produto informado deve ser um texto',
            'exists' => 'O código :attribute informado não existe'

        ];
    }
}
