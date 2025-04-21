<template>
    <div class="navbar-nav">
        <li class="nav-item">
            <h5>
            <router-link class="nav-link" :to="{ name: 'invitado-productosAll', params: {idLocalidad: localidad}}">
                Productos
            </router-link>
            </h5>
        </li>
        <li class="nav-item dropdown">
            <h5>
            <a class="nav-link dropdown-toggle" href="#" id="comercios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Comercios 
            </a>
            <div class="dropdown-menu" aria-labelledby="comercios">
                <router-link 
                 class="dropdown-item"
                 v-for="comercio in comercios" :key="comercio.id" 
                 :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: comercio.id}}">
                    {{comercio.nombre}}
                </router-link>
                <router-link v-if="comercios.length > 0" :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: 'comercios'}}"  class="dropdown-item">
                   <b>TODOS</b>
                </router-link>
                <router-link :to="{ name: 'anunciate-formulario', params: {idEntidad: 1}}"  class="dropdown-item badge badge-danger mt-1" href="#">
                   PUBLICÁ
                </router-link>
            </div>
            </h5>
        </li>                      
        <li class="nav-item dropdown">
            <h5>
            <a class="nav-link dropdown-toggle" href="#" id="servicios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Servicios
            </a>
            <div class="dropdown-menu" aria-labelledby="servicios">
                <router-link 
                 class="dropdown-item"
                 v-for="servicio in servicios" :key="servicio.id" 
                 :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: servicio.id}}">
                    {{servicio.nombre}}
                </router-link>
                <router-link v-if="servicios.length > 0" :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: 'servicios'}}"  class="dropdown-item">
                   <b>TODOS</b>
                </router-link>
                <router-link :to="{ name: 'anunciate-formulario', params: {idEntidad: 1}}"  class="dropdown-item badge badge-danger mt-1" href="#">
                    PUBLICÁ
                </router-link>
            </div>
            </h5>
        </li>                          
        <li class="nav-item dropdown">
            <h5>
            <a class="nav-link dropdown-toggle" href="#" id="turismo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Turismo
            </a>
            <div class="dropdown-menu" aria-labelledby="turismo">
                <router-link 
                 class="dropdown-item"
                 v-for="turismo in turismos" :key="turismo.id" 
                 :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: turismo.id}}">
                    {{turismo.nombre}}
                </router-link>
                <router-link v-if="turismos.length > 0" :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: 'turismo'}}"  class="dropdown-item">
                  <b>TODOS</b>
                </router-link>
                <router-link :to="{ name: 'anunciate-formulario', params: {idEntidad: 1}}"  class="dropdown-item badge badge-danger mt-1" href="#">
                    PUBLICÁ
                </router-link>
            </div>
            </h5>
        </li>    
        <li class="nav-item dropdown">
            <h5>
            <a class="nav-link dropdown-toggle" href="#" id="resto" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Gastronomía
            </a>
            <div class="dropdown-menu" aria-labelledby="resto">
                <router-link 
                 class="dropdown-item"
                 v-for="resto in restos" :key="resto.id" 
                 :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: resto.id}}">
                    {{resto.nombre}}
                </router-link>
                <router-link v-if="restos.length > 0" :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: 'gastronomia'}}"  class="dropdown-item">
                   <b>TODOS</b>
                </router-link>
                <router-link :to="{ name: 'anunciate-formulario', params: {idEntidad: 1}}"  class="dropdown-item badge badge-danger mt-1" href="#">
                    PUBLICÁ
                </router-link>
            </div>
            </h5>
        </li>
        <li class="nav-item">
            <h5>
            <router-link class="nav-link" :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad, idEntidadCategoria: 0}}">
                Todas
            </router-link>
            </h5>
        </li>
    </div>
</template>
<script>

export default {
  props:[
    'localidad'
  ],
  data(){
    return{
        comercios: [],
        servicios: [],
        turismos: [],
        restos: [],
    };
  },

  methods: {
        getComercios() {
        let me = this;

        var url = '/listado-comercios?localidad_id='+this.localidad;

       axios
            .get(url)
            .then(response => {
                me.comercios = response.data;
            })
            .catch(e => {
                console.log(e);
            });
        },

        getServicios() {
        let me = this;

        var url = '/listado-servicios?localidad_id='+this.localidad;

       axios
            .get(url)
            .then(response => {
                me.servicios = response.data;
            })
            .catch(e => {
                console.log(e);
            });
        },

        getTurismo() {
        let me = this;

        var url = '/listado-turismo?localidad_id='+this.localidad;

       axios
            .get(url)
            .then(response => {
                me.turismos = response.data;
            })
            .catch(e => {
                console.log(e);
            });
        },

        getResto() {
        let me = this;

        var url = '/listado-resto?localidad_id='+this.localidad;

       axios
            .get(url)
            .then(response => {
                me.restos = response.data;
            })
            .catch(e => {
                console.log(e);
            });
        }
  },

    mounted(){
        this.getComercios()
        this.getServicios()
        this.getTurismo()
        this.getResto()
    }
};
</script>