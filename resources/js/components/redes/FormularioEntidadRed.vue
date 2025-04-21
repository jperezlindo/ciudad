<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="alert alert-info mt-2" role="alert">
          Aquí podrás cargar tus redes sociales, como tu perfil o página de Facebook, Instagram, Whatsapp, Número telefónico, etc. 
          Estas van a aparecer debajo de la descripción de tu comercio/servicio para que los visitantes de la página los puedan ver.
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary shadow mb-3">
          <div class="card-header">
            <div class="text-left">
              <h4 slot="header" class="mb-0" v-if="entidad_red_id">EDITAR RED SOCIAL</h4>
              <h4 slot="header" class="mb-0" v-else>NUEVA RED SOCIAL</h4>
            </div>
          </div>
          <div class="card-body">
            <form class="form-group" @submit.prevent="check()">
              <div class="row form-group">
                <div class="col-md-5">
                  <small class="font-weight-bold">Link</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    maxlength="255"
                    v-model="entidad_red.link"
                  />
                </div>
                <div class="col-md-5">
                  <small class="font-weight-bold">Red</small>
                  <select
                    required
                    class="form-control"
                    v-model="entidad_red.red_id"
                    >                   
                    <option
                        v-for="red in redes"
                        :key="red.id"
                        :value="red.id"
                    >{{red.nombre}}</option>
                   </select>
                </div>
                <!--SPINNER-->
                <div class="col-md-2" v-if="guardandoRed">
                    <br>
                    <button class="btn btn-primary" type="button" disabled>
                      <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                      <strong class="text-white">Guardando</strong>
                    </button>
                </div>
                <!--FIN SPINNER-->
                <div class="col-md-2" v-else>
                  <br>
                  <button class="btn btn-primary" v-if="entidad_red_id">Actualizar</button>
                  <button class="btn btn-primary" v-else>Guardar</button>
                </div>
              </div>
            </form>
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
      entidad_red_id: this.$route.params.idEntidadRed,
      entidad_red: {
        link: "",
        red_id: ""
       },
       redes: [],
       guardandoRed: 0
    };
  },

  methods: {
    storeEntidadRed() {
      let me = this;
      var url = "/crear-entidad-red";
      me.guardandoRed = 1;
      axios
        .post(url, me.entidad_red)
        .then(response => {
          me.guardandoRed = 0;
          swalConfirm.fire({
            title: '¿Desea agregar más redes sociales?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'SI',
            cancelButtonText: 'NO',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              me.entidad_red = {
                link: "",
                red_id: ""
              };
              me.getRedes()
            } else {
              me.$router.push({name: 'listado-entidad-redes'});
            }
          })
        })
        .catch(e => {
          console.log(e);
        });
    },
    /*storeEntidadRed() {
      let me = this;

      var url = "/crear-entidad-red";

      axios
        .post(url, me.entidad_red)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: 'Red Social creada con éxito..'
          })
          me.$router.push({name: 'listado-entidad-redes'});
        })
        .catch(e => {
          console.log(e);
          
        });
    },*/

    updateEntidadRed() {
      let me = this;

      var url = "/actualizar-entidad-red?entidad_red_id=" + me.entidad_red_id;

      axios
        .put(url, me.entidad_red)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: 'Red Social actualizada con éxito..'
          })
          me.$router.push({name: 'listado-entidad-redes'});
        })
        .catch(e => {
          console.log(e);
          
        });
    },

    editEntidadRed() {
      let me = this;

      var url = "/editar-entidad-red?entidad_red_id=" + me.entidad_red_id;
      axios
        .get(url)
        .then(response => {
          me.entidad_red = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    getRedes() {
      let me = this;

      var url = '/listado-redes';
      axios
        .get(url)
        .then(response => {
          me.redes = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    check(){
      if(this.entidad_red_id){
        this.updateEntidadRed();
      } else {
        this.storeEntidadRed();
      }
    }

  },
  
  beforeCreate(){
    if (this.$router.app.auth == 0 ){
      this.$router.replace({ name: 'invitado-invitado'})
    }
  },
  
  mounted() {
    this.getRedes();
    if (this.entidad_red_id) {
      this.editEntidadRed();
    };
  }
};
</script>