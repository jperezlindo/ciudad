<template>
<div>      
    <div class="row">
        <h2 class="display-4 mx-auto text-white font-weight-bold">
            {{entidad.nombre}}
            <img :src="'imagenes/entidades/' + entidad.logo" width="45px" class="rounded mb-2" >
        </h2>
    </div>
    <div class="row ml-1">
        <h5 class="mx-auto text-white font-weight-bold">
            {{entidad.descripcion}}
        </h5>
    </div>
    <div class="row d-flex justify-content-center">
        <div v-for="red in redesEntidades" :key="red.id">
            <h3>
                <a :href="red.link" v-html="red.icono" class="badge badge-primary text-white mx-2" target="_blank"></a>
            </h3>
        </div>

        <div>
            <h3>
                <router-link :to="{ name: 'anunciate-formulario', params:{idEntidad: entidad_id}}"  class="nav-link badge badge-primary text-white mx-2" href="#">
                    <i class="far fa-envelope"></i>
                </router-link>
            </h3>
        </div>
        <div v-if="entidad.coordenadas">
            <h3>
            <a :href="entidad.coordenadas" class="badge badge-primary text-white mx-2" target="_blank">
                <i class="fas fa-map-marker-alt"></i> ¡Como llegar!
            </a>
            </h3> 
        </div>
        <div>
            <h3>
                <a :href="'https://api.whatsapp.com/send?phone=+549'+entidad.tel_cel" class="badge badge-success text-white mx-2" target="_blank">
                    <i class="fab fa-whatsapp"></i> {{entidad.tel_cel}}
                </a>
            </h3>
        </div>
    </div>
</div>
</template>
<script>
export default {
    
    props: ['entidad_id'],

    data() {
        return{
            entidad: [],
            redesEntidades: []
        }
    },

    methods:{
        getEntidad() {
            
            let me = this
            var url = "/editar-entidad?entidad_id=" + me.entidad_id

            axios
                .get(url)
                .then(response => {
                    me.entidad = response.data.entidad 
                })
                .catch(e => {
                    console.log(e)
                })
        },
        getEntidadRedes() {
            let me = this

            var url = "/listado-entidad-redes?entidad_id=" + this.entidad_id
            axios
                .get(url)
                .then(response => {
                    me.redesEntidades = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
    },

    mounted(){
        this.getEntidad()
        this.getEntidadRedes()
    }
}
</script>