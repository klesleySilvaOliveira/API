<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            //colunas
            $table->id();
            $table->unsignedBigInteger('cod_produto')->unique();
            $table->string('nome_produto', 30);
            $table->float('valor_produto', 8,2)->default(0.01);
            $table->unsignedBigInteger('estoque')->default(0);
            $table->unsignedBigInteger('cidade_id')->default(1);
            $table->softDeletes();
            $table->timestamps();

            //fk cidades apontando para id
            $table->foreign('cidade_id')->references('id')->on('cidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::create('produtos', function (Blueprint $table) {
            //remove a fk
            $table->dropForeign('produtos_cidade_id_foreign');

            //remove o soft delete
            $table->dropSoftDeletes();
        });*/
        Schema::dropIfExists('produtos');
    }
}
