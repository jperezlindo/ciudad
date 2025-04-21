<template>
<div>
    <div>
        <div v-if="producto.length == 0">
            <loading nombre="Producto"/>
        </div>
    </div>
    <div class="container">
        <!--EntidadData-->
        <div class="text-center">
            <entidad-data :entidad_id="entidad_id"/>
        </div>
        <hr>
        <div class="card shadow">
            <div class="text-center mt-3">
                <img class="card-img-center rounded img-fluid" width="300px" height="400px" :src="'imagenes/productos/' + producto.imagen">
            </div>
            

            <div class="card-body">
                <h2 class="card-title text-center">
                    {{producto.nombre}}
                    <span class="badge badge-pill badge-success">${{producto.precio}}</span>
                </h2>
                <h6 class="card-title text-center mb-3">{{producto.marca}}</h6>
                <p class="card-text text-center">{{producto.descripcion}}</p>
                <hr>
                <p class="text-center">Si te interesa lo que estás viendo, envianos tus datos y nos contactaremos con usted o envianos un whatsapp.</p>
                <form @submit.prevent="loquiero()">
                    <div class="form-row">
                        <div class="col-md-5">
                            <input type="text" 
                                class="form-control mb-1" 
                                placeholder="Apellido y Nombre" 
                                v-model="quiero.usuario"
                                required
                                maxlength="30">
                        </div>
                        <div class="col-md-4">
                            <input type="text" 
                                class="form-control mb-1" 
                                placeholder="Telefono/Celular"
                                v-model="quiero.contacto"
                                required
                                maxlength="15"
                                @keypress="soloNumeros()">
                        </div>
                        <!--SPINNER-->
                        <div class="row" v-if="imagenCargar">
                            <div class="mx-auto ">
                            <button class="btn btn-primary" type="button" disabled>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                <strong class="text-white">Enviando datos...</strong>
                            </button>
                            </div>
                        </div>
                        <!--FIN SPINNER-->
                        <div class="col-md-3" v-else>
                            <button type="submit" class="form-control btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <router-link class="btn btn-block btn-info" :to="{ name: 'invitado-productosAll', params: {idLocalidad: localidad_id}}">
                            Ir a productos
                        </router-link>
                    </div>
                    <div class="col-md-6">
                        <router-link class="btn btn-block btn-info" :to="{ name: 'invitado-productos', params: {idLocalidad: localidad_id, idEntidad : entidad_id}}">
                            Ir al anunciante
                        </router-link>
                    </div>
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
                producto:[],
                localidad_id: null,
                entidad_id: null,
                quiero: {
                    usuario: '',
                    contacto: '',
                    comentario: '',
                    entidad_id: '',
                },
                imagenCargar: 0 
            }
        },

        methods: {
            getProducto(id){
                let me = this

                var url = "/ver-producto?producto_id=" + id

                axios.get(url)
                    .then(response => {
                        me.producto = response.data
                        this.quiero.comentario = 'Quiero este producto: ' + 'Codigo: '+ this.producto.codigo + ', Producto: '+ this.producto.nombre +', Marca: '+ this.producto.marca
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },

            loquiero(){
                let me = this
                var url = '/crear-mensaje'
                
                if (me.quiero.usuario === '') return
                if (me.quiero.contacto === '') return

                me.imagenCargar = 1;

                axios.post(url,me.quiero)
                    .then(response => {
                        me.imagenCargar = 0;
                        me.quiero.usuario = '';
                        me.quiero.contacto = '';
                        Swal.fire('Gracias por elegirnos, nos pondremos en contacto para confirmar el pedido.')
                        //me.$router.push({name: 'invitado-productos', params:{idLocalidad: this.localidad_id , idEntidad: this.entidad_id}})
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },

            soloNumeros(evt) {
                var e = window.event || evt;
                var charCode = e.which || e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    if (window.event) //IE
                    window.event.returnValue = false; //Firefox
                    else e.preventDefault();
                }
                return true;
            }
        },

        created(){
            this.entidad_id =this.$route.params.idEntidad
            this.localidad_id = this.$route.params.idLocalidad
            this.$router.app.id_localidad = this.localidad_id 
        },

        mounted(){

            this.getProducto(this.$route.params.idProducto)
            this.$router.app.mostrarme = 0
            this.quiero.entidad_id = this.entidad_id

        },      
    }


</script>  