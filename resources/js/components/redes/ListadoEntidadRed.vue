<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="alert alert-info mt-2 mx-2" role="alert">
          Aquí podrás ver tus redes sociales, como tu perfil o página de Facebook, Instagram, Whatsapp, Número telefónico etc. 
          Estas van a aparecer debajo de la descripción de tu comercio/servicio para que los visitantes de la página los puedan ver. Si querés cargar 
          una red social hacé click en el botón en <b>Nueva Red Social</b>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>LISTADO DE REDES SOCIALES</h3>
              </div>
              <div class="col-md-6 text-right">
                <router-link :to="{ name: 'crear-entidad-red'}" class="btn btn-primary">
                  Nueva Red Social
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body text-primary">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Link o contacto</th>
                    <th scope="col" class="text-center">Red Social</th>
                    <th scope="col" class="text-center">Editar</th>
                    <th scope="col" class="text-center">Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="red in redesEntidades" :key="red.id">
                    <td><a :href="red.link" v-text="red.link" target="_blank"></a></td>
                    <td v-html="red.icono" class="text-center"></td>
                    <td class="text-center">
                      <router-link type="button" class="btn btn-outline-primary btn-sm" 
                        :to="{ name: 'editar-entidad-red', params: {idEntidadRed : red.id}}">
                        <i class="fas fa-edit"></i>
                      </router-link>
                    </td>
                    <td class="text-center">
                      <button @click="deleteRedEntidad(red.id)" class="btn btn-outline-danger btn-sm" id="botonEliminar">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--SPINNER-->
            <div class="row" v-if="!redesEntidades.length">
              <div class="mx-auto ">
                <button class="btn btn-primary" type="button" disabled>
                  <div v-if="!noRedes">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <strong class="text-white">Cargando redes sociales...</strong>
                  </div>
                  <div v-else>
                    <strong class="text-white">Ninguna red social para mostrar</strong>
                  </div>
                </button>
              </div>
            </div>
            <!--FIN SPINNER-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      redesEntidades: [],
      noRedes: ''
    };
  },

  methods: {
    getEntidadRedes() {
      let me = this;

      var url = '/listado-entidad-redes';
      axios
        .get(url)
        .then(response => {
          //me.redesEntidades = response.data;
          var data = response.data
          if (data.length == 0){
              me.noRedes = 1
              me.redesEntidades = data
          }else{
              me.noRedes = 0
              me.redesEntidades = data
          }
        })
        .catch(error => {
          console.log(error);
        });
    },

    deleteRedEntidad(entidad_red_id) {
      document.getElementById('botonEliminar').disabled=true;

      let me = this;
      var url = "/eliminar-entidad-red?entidad_red_id=" + entidad_red_id;

      swalConfirm.fire({
          title: '¿Está seguro que desea eliminar esta red social para siempre?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'SI',
          cancelButtonText: 'NO',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            axios
              .delete(url)
              .then(response => {
                  Toast.fire({
                      icon: 'success',
                      title: 'Red social eliminada correctamente'
                  })
                  document.getElementById('botonEliminar').disabled=false;
                  me.getEntidadRedes();
              })
              .catch(e => {
                  console.log(e);
              });
          } else {
            document.getElementById('botonEliminar').disabled=false;
          }
        })   
    }

  },

  beforeCreate(){
      if (this.$router.app.auth == 0){
          this.$router.push({ name: 'invitado-invitado'})
      }
  },

  mounted() {
    this.getEntidadRedes();
  }
};
</script>