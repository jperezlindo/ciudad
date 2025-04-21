<template>
<div>    
    <div class="my-3"> 
        <div class="container text-center"> 
            <router-link :to="{ name: 'anunciate-formulario', params: {idEntidad: 1}}"  class="badge badge-danger mt-1" href="#">
                <h1>¡PUBLICÁ!</h1>
            </router-link>
        </div>
        <br>
        <div class="container text-center">
            <h1 class="text-white font-weight-bold display-2">¡Encontrá lo que necesitás!</h1>
            <h1 class="text-white font-weight-bold">Explorá lo que podés conseguir en las siguientes localidades...</h1>
            <br> 
        </div>
        <div v-if="localidades.length == 0">
            <loading nombre="Localidades"/>
        </div>
        <div v-else>    
            <localidades class="mt-3" :localidades="localidades"/>
            <br>
            <div class="container text-center"> 
                <div class="alert alert-primary" role="alert">
                    <h3>Seleccioná una localidad, para ver los comercios y servicios adheridos</h3> 
                </div>
            </div>
        </div>   
    </div>
</div>
</template>
<script>

export default {
    
    data(){
        return{
            provincia_id: 1,
            localidades: [],
            //buscar: ''
        }
    },

    methods: {
        getLocalidades() {
            let me = this
            var url = "/localidades" //+ me.provincia_id // + '&buscar='+ me.buscar

            axios
                .get(url)
                .then(response => {
                me.localidades = response.data
                })
                .catch(e => {
                    console.log(e)
                })
        },
    },

    mounted(){
        this.getLocalidades()
    },

}
</script>  