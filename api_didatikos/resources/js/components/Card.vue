<template>
    <!-- Inicio da pesquisa -->
    <div class="card mb-3">
        <div class="card-header">{{titulo}}</div>

        <div class="card-body">
            <slot name="conteudo"></slot>
        </div>
        <div class="card-footer">
            <slot name="rodape"></slot>
        </div>
    </div>
    <!-- Fim da pesquisa -->
</template>

<script>
    export default {
        props: ['titulo']
    }
</script>