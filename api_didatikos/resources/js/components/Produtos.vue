<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Inicio da pesquisa -->
                <card-component titulo="Busca de Produtos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="Código do produto" id="inputCod" id-help="codHelp" texto-ajuda="Opcional. Informe o Código do produto.">
                                    <input type="number" class="form-control" id="inputCod" aria-describedby="codHelp" placeholder="Insira aqui" v-model='busca.cod_produto'>
                                </input-container-component>                            
                                
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome do Produto" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome do produto.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Insira aqui" v-model='busca.nome'>
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim da pesquisa -->

                <!-- Inicio dos registros -->
                <card-component titulo="Relação de Produtos">
                    <template v-slot:conteudo>
                        <table-products-component :dados="produtos" :atualizar="true" :remover="true" :titulos="['Codigo', 'Nome', 'Valor', 'Estoque', 'Cidade']" :cities="cidades"></table-products-component>
                    </template>
                    <template v-slot:rodape>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalProdutos">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim dos registros -->
            </div>
        </div>
        <modal-component id="modalProdutos" titulo="Adicionar Produto">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o produto" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <!-- Inicio dos inputs no modal -->
                <div class="form-group">
                    <input-container-component titulo="Código do produto" id="novoCodigo" id-help="novoCodigoHelp" texto-ajuda="Obrigatório. Informe o codigo do produto.">
                        <input type="number" class="form-control" id="novoCodigo" aria-describedby="novoCodigoHelp" placeholder="Insira aqui" v-model="codigoProduto">
                    </input-container-component> 
                </div>               
                <div class="form-group">
                    <input-container-component titulo="Nome do Produto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Obrigatório. Informe o nome do produto.">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Insira aqui" v-model="nomeProduto">
                    </input-container-component> 
                </div>               
                <div class="form-group">
                    <input-container-component titulo="Valor do Produto" id="inputValor" id-help="valorHelp" texto-ajuda="Obrigatório. Informe o valor do produto.">
                        <input type="number" class="form-control" id="inputValor" aria-describedby="valorHelp" placeholder="Insira aqui" v-model="valorProduto">
                    </input-container-component> 
                </div>               
                <div class="form-group">
                    <input-container-component titulo="Estoque do Produto" id="inputEstoque" id-help="estoqueHelp" texto-ajuda="Obrigatório. Informe a quantidade em estoque do produto.">
                        <input type="number" class="form-control" id="inputEstoque" aria-describedby="estoqueHelp" placeholder="Insira aqui" v-model="estoqueProduto">
                    </input-container-component> 
                </div>               
                <div class="form-group">
                    <input-container-component titulo="Cidade" id="selectCidade" id-help="cidadeHelp" texto-ajuda="Obrigatório. Informe a cidade onde o produto se situa.">
                        <div class="input-group mb-3">
                            <select class="custom-select" id="selectCidade" aria-describedby="cidadeHelp" v-model="cidade">
                                <option value="" disabled>-- Selecione uma Cidade --</option>
                                <option v-for="cid in cidades" :value="cid.id" :key="cid.id">{{cid.nome_cidade}}</option>
                            </select>
                        </div>
                    </input-container-component> 
                </div>
                <!-- Fim dos inputs no modal -->    
            </template>
            <template v-slot:rodape>
                <!-- Botões no modal --> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>         
        </modal-component>  
    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/produto',
                urlCidades: 'http://localhost:8000/api/v1/cidade',
                urlFiltro: '',
                codigoProduto: '',
                nomeProduto: '',
                valorProduto: '',
                estoqueProduto: '',
                cidade: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                produtos: [],
                cidades: [],
                busca: {cod_produto: '', nome: ''}
            }
        },
        computed: {
            token(){
                let token = document.cookie.split(';').find(indice => {
                    return indice.includes('token=')
                })

                token = token.split('=')[1]
                token = 'Bearer ' + token

                return token
            }
        },
        methods: {
            pesquisar(){

                let filtro = ''

                for(let chave in this.busca){
                    if(this.busca[chave]){
                        if(filtro != ''){
                            filtro += ";"
                        }
                        filtro += chave + ':like:' + this.busca[chave]
                    }                    
                }
                if(filtro != ''){
                    this.urlFiltro = '&filtro='+filtro
                }
                else{
                    this.urlFiltro = ''
                }
                this.carregarLista()                
            },
            carregarLista(){
                
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }
                let url = this.urlBase + '?' + this.urlFiltro

                axios.get(url, config)
                    .then(response => {
                        this.produtos = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })

                axios.get(this.urlCidades, config)
                    .then(response => {
                        this.cidades = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            salvar(){
                //console.log(this.codigoProduto, this.nomeProduto, this.valorProduto, this.estoqueProduto, this.cidade)

                let formData = new FormData()
                formData.append('cod_produto', this.codigoProduto)
                formData.append('nome_produto', this.nomeProduto)
                formData.append('valor_produto', this.valorProduto)
                formData.append('estoque', this.estoqueProduto)
                formData.append('cidade_id', this.cidade)

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = response
                        console.log(response)
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = errors.response
                        //console.log(errors.response)
                    })
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>
