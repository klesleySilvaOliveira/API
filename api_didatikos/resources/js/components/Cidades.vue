<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Inicio dos registros -->
                <card-component titulo="Relação de Cidades">
                    <template v-slot:conteudo>
                        <table-cities-component :dados="cidades" :titulos="['Codigo', 'Nome', 'Estado']"></table-cities-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCidades">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim dos registros -->
            </div>
        </div>
        <modal-component id="modalCidades" titulo="Adicionar Cidade">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a cidade" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <!-- Inicio dos inputs no modal -->
                <div class="form-group">
                    <input-container-component titulo="Nome da Cidade" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Obrigatório. Informe o nome da Cidade.">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Insira aqui" v-model="nomeCidade">
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Estado" id="selectEstado" id-help="estadoHelp" texto-ajuda="Obrigatório. Informe o Estado onde a cidade se situa.">
                        <div class="input-group mb-3">
                            <select class="custom-select" id="selectEstado" aria-describedby="estadoHelp" v-model="estado">
                                <option value="" disabled>-- Selecione um Estado --</option>
                                <option value="AC">Acre</option> 
                                <option value="AL">Alagoas</option> 
                                <option value="AP">Amapá</option> 
                                <option value="AM">Amazonas</option> 
                                <option value="BA">Bahia</option> 
                                <option value="CE">Ceará</option> 
                                <option value="DF">Distrito Federal</option> 
                                <option value="ES">Espírito Santo</option> 
                                <option value="GO">Goiás</option> 
                                <option value="MA">Maranhão</option> 
                                <option value="MT">Mato Grosso</option> 
                                <option value="MS">Mato Grosso do Sul</option> 
                                <option value="MG">Minas Gerais</option> 
                                <option value="PA">Pará</option> 
                                <option value="PB">Paraíba</option> 
                                <option value="PR">Paraná</option> 
                                <option value="PE">Pernambuco</option> 
                                <option value="PI">Piauí</option> 
                                <option value="RJ">Rio de Janeiro</option> 
                                <option value="RN">Rio Grande do Norte</option> 
                                <option value="RS">Rio Grande do Sul</option> 
                                <option value="RO">Rondônia</option> 
                                <option value="RR">Roraima</option> 
                                <option value="SC">Santa Catarina</option> 
                                <option value="SP">São Paulo</option> 
                                <option value="SE">Sergipe</option> 
                                <option value="TO">Tocantins</option>
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
                urlBase: 'http://localhost:8000/api/v1/cidade',
                nomeCidade: '',
                estado: '',
                transacaoStatus: '',
                transacaoDetalhes: {},
                cidades: [],
                busca: {nome: ''}
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
            carregarLista(){
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }
                axios.get(this.urlBase, config)
                    .then(response => {
                        this.cidades = response.data
                        console.log(this.cidades)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            salvar(){
                //console.log(this.nomeCidade, this.estado)
                
                let formData = new FormData()
                formData.append('nome_cidade', this.nomeCidade)
                formData.append('estado', this.estado)

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
                        //console.log(response)
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = errors.response
                        //console.log(this.transacaoDetalhes.data.message)
                    })
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>
