<template>
<div>
    <div>
        <div v-if="productos.length == 0 && !noProductos">
            <loading nombre="PRODUCTOS..."/>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <div class="container">
                <div class="input-group my-3">
                    <input id="buscar" type="text" 
                        class="form-control shadow" 
                        placeholder="INGRESA EL NOMBRE DEL PRODUCTO QUE BUSCAS" aria-label="Recipient's username" aria-describedby="basic-addon2"
                        v-model="buscar"    
                        @keyup.enter="getProductos()"                
                    />
                    <div class="input-group-append">
                        <button class="input-group-text" id="basic-addon2" @click="getProductos()"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" v-if="noProductos">
            <div class="row">
                <button class="btn btn-block btn-primary" type="button" disabled>
                    <span class="" role="status" aria-hidden="true"></span>
                    <h1>Sin productos/servicios.</h1>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="card-group mb-1 col-md-3" v-for="producto in productos" :key="producto.id">
                <router-link class="card shadow" :to="{ name: 'invitado-producto', params: {idProducto : producto.id, idLocalidad: localidad_id, idEntidad: producto.entidad_id}}">     
                    
                    <img :src="'imagenes/productos/' + producto.imagen" class="rounded mx-auto d-block img-fluid" width="300px" height="400px" alt="...">
                    
                    <div class="card-body">
                        <font color=orange>
                            <h5 class="card-title text-center">{{producto.nombre}}</h5>
                            <h6 class="card-title text-center">{{producto.marca}}</h6>
                        </font>
                    </div>
                    <div class="card-footer bg-white">
                        <h4 class="card-title text-center">
                            <span v-if="producto.precio" class="badge badge-pill badge-success">
                                $ {{producto.precio}}
                            </span>
                            <span v-else class="badge badge-pill badge-secondary">-</span>
                        </h4>
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
            productos: [],
            all: 0,
            buscar: '',
            noProductos: ''            
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

        getProductos() {
            let me = this

            var url = '/invitado-listado-productos-disponibles?buscar=' + me.buscar + '&idLocalidad=' + me.localidad_id 
            
            axios
            .get(url)
            .then(response => {
                var data = me.shuffle(response.data)
                if (data.length == 0){
                    me.noProductos = 1
                    me.productos = data
                }else{
                    me.productos = data.sort()
                    me.noProductos = 0
                }
            })
            .catch(e => {
                console.log(e)
            })
        },        
    },
 
    created(){
        this.localidad_id = this.$route.params.idLocalidad
        this.$router.app.id_localidad = this.$route.params.idLocalidad
        this.$router.app.mostrarme = 0 
    },

    mounted(){
        //document.getElementById("buscar").focus()
        this.getProductos()         
    },
}
</script>  