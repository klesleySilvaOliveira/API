<template>
    <div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col" v-for="titulo, key in titulos" :key="key">{{titulo}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dado in dados" :key="dado.id">
                    <th scope="row">{{dado.id}}</th>
                    <td>{{dado.nome_cidade}}</td>
                    <td>{{dado.estado}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos']
    }
</script>
