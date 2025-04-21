<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary shadow mb-3">
          <div class="card-header">
            <div class="text-left">
              <h4 slot="header" class="mb-0" v-if="red_id">EDITAR RED</h4>
              <h4 slot="header" class="mb-0" v-else>NUEVA RED</h4>
            </div>
          </div>
          <div class="card-body">
            <form class="form-group" @submit.prevent="check()">
              <div class="row form-group">
                <div class="col-md-5">
                  <small class="font-weight-bold">Nombre</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    v-model="red.nombre"
                    maxlength="100"
                  />
                </div>
                <div class="col-md-5">
                  <small class="font-weight-bold">Ícono</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    v-model="red.icono"
                  />
                </div>
                <div class="col-md-2">
                  <br>
                  <button class="btn btn-primary" v-if="red_id">Actualizar</button>
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
      red_id: this.$route.params.idRed,
      red: {
        nombre: "",
        icono: ""
       }
    };
  },

  methods: {
    storeRed() {

      let me = this;

      var url = "/crear-red";

      axios
        .post(url, this.red)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: 'Red Social creada con éxito..'
          })
          me.$router.push({name: 'listado-redes'});
        })
        .catch(e => {
          console.log(e);
          
        });
    },

    updateRed() {
      let me = this;

      var url = "/actualizar-red?red_id=" + me.red_id;

      axios
        .put(url, me.red)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: 'Red actualizada con éxito..'
          })
          me.$router.push({name: 'listado-redes'});
        })
        .catch(e => {
          console.log(e);
          
        });
    },

    editRed() {
      let me = this;

      var url = "/editar-red?red_id=" + me.red_id;
      axios
        .get(url)
        .then(response => {
          me.red = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    check(){
      if(this.red_id){
        this.updateRed();
      } else {
        this.storeRed();
      }
    },

    
  },

  beforeCreate(){
        if (this.$router.app.auth != 1){
            this.$router.push({ name: 'invitado-invitado'})
        }
    },

  created(){
      this.$router.app.mostrarme = 0 
    },

  mounted() {
    if (this.red_id) {
      this.editRed();
    };
  }

};
</script>