<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <entidades-formulario></entidades-formulario>
                <usuarios-formulario></usuarios-formulario>
                <botones-crear-cancelar quien="entidadUsuario" crear="crear"></botones-crear-cancelar>
            </div>   
        </div>
    </div>
</template>
<script>

import bus from "../eventBus";

export default {

    data() {
        return {
            entidad: 'entidad',
            usuario: 'usuario',
        };
    },
    
    beforeCreate(){
        if (this.$router.app.auth != 1){
            this.$router.push({ name: 'invitado-invitado'})
        }
    },
    
    mounted() {
        bus.$on('entidadOK', data => {
            this.entidad = 'verificado'
            bus.$emit('store')
        })

        bus.$on('usuarioOK', data => {
            this.usuario = 'verificado'
            bus.$emit('store')
        })

        bus.$on('store', data => { 
            if (this.entidad === this.usuario){
                bus.$emit('crear-entidad')
            }
        })

    },
}
</script>