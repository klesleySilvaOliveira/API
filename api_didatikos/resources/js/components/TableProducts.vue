<template>
    <div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col" v-for="titulo, key in titulos" :key="key">{{titulo}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dado in dados" :key="dado.cod_produto">
                    <th scope="row">{{dado.cod_produto}}</th>
                    <td>{{dado.nome_produto}}</td>
                    <td>{{dado.valor_produto}}</td>                    
                    <td>{{dado.estoque}}</td>
                    <td>{{cities[dado.cidade_id - 1].nome_cidade}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'cities', 'remover'],
        data(){
            return{
                remove: ''
            }
        },
        methods: {
        }   
    }
</script>
