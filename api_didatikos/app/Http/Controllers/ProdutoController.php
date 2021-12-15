<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;

class ProdutoController extends Controller
{
    public function __construct(Produto $produto){
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->produto->all();
        return response()->json($produtos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdutoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdutoRequest $request)
    {
        //para funcionar, é necessário alterar o valor booleano no metodo 'authorize()' na request
        //tratativas das colunas
        $request->validate($this->produto->rules(), $this->produto->feedback());
        //o validade tende a retornar à requisição anterior, necessitando que o client adicione ao header da requisição 'Accept - application/json'

        $produto = $this->produto->create($request->all());
        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->produto->find($id);
        if($produto === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe!'], 404);
        }
        return response()->json($produto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdutoRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdutoRequest $request, $id)
    {
        $produto = $this->produto->find($id);
        if($produto === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe!'], 404);
        };
        $request->validate($produto->rules(), $produto->feedback());
        $produto->update($request->all()); 
        return response()->json($produto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);
        if($produto === null){
            return response()->json(['erro' => 'Registro solicitado não existe!'], 404);
        };
        $produto->delete();
        return response()->json(['msg' => 'O produto foi removido com sucesso!'], 200);
    }
}
