<template>
<div>
    <div v-if="entidades.length == 0 && !noEntidades">
        <loading nombre="COMERCIOS Y SERVICIOS..."/>
    </div>
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="input-group my-3">
                    <input id="buscar" type="text" 
                        class="form-control shadow" 
                        placeholder="INGRESA EL NOMBRE DEL COMERCIO O SERVICIO QUE DESEAS VISITAR" aria-label="Recipient's username" aria-describedby="basic-addon2"
                        v-model="buscar"    
                        @keyup.enter="getEntidades()"                
                    />
                    <div class="input-group-append">
                        <button class="input-group-text" id="basic-addon2" @click="getEntidades()"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-if="noEntidades" class="container">
            <div class="row">
                <div class="input-group my-3">
                    <button class="btn btn-block btn-primary" type="button" disabled>
                    <span class="" role="status" aria-hidden="true"></span>
                        <h1>Actualmente el comercio/servicio que buscás no está adherido.</h1>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card-group col-md-3 my-3" v-for="entidad in entidades" :key="entidad.id">
                <router-link class="card shadow" style="color:#FF0000" :to="{ name: 'invitado-productos', params: {idLocalidad: localidad_id,idEntidad : entidad.id}}">
                    <img :src="'imagenes/entidades/' + entidad.logo" class="rounded mx-auto d-block img-fluid" width="300px" height="400px" alt="...">
                    <div class="card-body">
                        <font color=orange>
                            <h5 class="card-title text-center">{{entidad.nombre}}</h5>
                            <h6 class="card-title text-center">{{entidad.tel_cel}}</h6>
                            <p class="card-title text-center">{{entidad.direccion}}</p>
                        </font>
                    </div>
                    <div class="card-footer">
                        <font color=orange>
                        <p v-if="entidad.categoria_entidad.nombre" class="card-title text-center">{{entidad.categoria_entidad.nombre}}</p>
                        <p v-else class="card-title text-center">{{entidad.categoria_entidad}}</p>
                        </font>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</div>    
</template>


<script>

export default {
    
    data(){
        return{
            localidad_id: null, 
            categoria_entidad_id: 0,
            entidades: [],
            all: 0,
            buscar: '',
            noEntidades: ''
        }
    },

    methods: {
        shuffle(arr) {
            var i,
                j,
                temp;
            for (i = arr.length - 1; i > 0; i--) {
                j = Math.floor(Math.random() * (i + 1));
                temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }
            return arr;    
        },

        getEntidades() {

            let me = this           
            
            var url = '/listado-entidades-disponibles?buscar=' + me.buscar
                                                               +'&idLocalidad=' + me.localidad_id
                                                               +'&idCaEn=' + me.categoria_entidad_id

            axios
                .get(url)
                .then(response => {
                    var data = me.shuffle(response.data)

                    if (data.length == 0){
                        me.noEntidades = 1
                        me.entidades = data
                    }else{
                        me.entidades = data
                        me.noEntidades = false
                    }

                })
                .catch(e => {
                    console.log(e)
                })
        },

        invitado(){
            let me = this
            me.$router.push({ name: "invitado-invitado" })
        }

    },
    watch: {
        '$route.params.idEntidadCategoria': function (id) { 
            this.categoria_entidad_id = this.$route.params.idEntidadCategoria
            this.getEntidades()
        },
    },

    created(){
        this.localidad_id = this.$route.params.idLocalidad
        this.categoria_entidad_id = this.$route.params.idEntidadCategoria 
        this.$router.app.mostrarme = 0         
    },

    mounted(){
        //document.getElementById("buscar").focus()
        this.getEntidades()
        this.$router.app.id_localidad = this.localidad_id
        //console.log(window.history)
    },

}
</script>  