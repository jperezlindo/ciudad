<template>
  <div class="container">
    <div>
      <div class="row">
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card border-primary mb-3 shadow">
            <div class="card-header">
              <div class="row">
                <div class="col-md-7">
                  <h3>Listado de mensajes de clientes</h3>
                </div>
                <div class="col-md-5 text-right">
                  <a @click="getMensajes(1)" href="#">Clientes atendidos</a> || <a @click="getMensajes(0)" href="#">Clientes no atendidos</a>
                </div>
              </div>
            </div>
            <div class="card-body text-primary">
              <div  v-if="noMensajes" class="alert alert-danger" role="alert">
                  <h3>Actualmente no tienes nuevos mensajes</h3>
              </div>
              <div v-else class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Usuario</th>
                      <th scope="col">Contacto</th>
                      <th scope="col">Localidad</th>
                      <th scope="col">Comentario</th>
                      <th class="text-center" scope="col" >No atendido/Atendido</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="mensaje in mensajes" :key="mensaje.id">
                      <th>{{mensaje.id}}</th>
                      <th>{{mensaje.usuario}}</th>
                      <td><a :href="'https://api.whatsapp.com/send?phone=+549'+mensaje.contacto" target="_blanck">{{mensaje.contacto}}</a></td>
                      <td >{{mensaje.localidad}}</td>
                      <td>{{mensaje.comentario}}</td>
                      <td>
                        <div class="custom-control custom-switch text-center">
                          <input type="checkbox" class="custom-control-input"
                          v-bind:id="mensaje.id" 
                          v-bind:checked="(mensaje.leido ? true : '')"
                          @click="cambiarEstado(mensaje.id)"/>
                          <label class="custom-control-label" v-bind:for="mensaje.id"></label>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import bus from "../eventBus";

export default {

  data() {
    return {
      mensajes: [],
      noMensajes: ''
    };
  },

  methods: {
    getMensajes(atendidos) {
      let me = this;
      
      var url = '/listado-mensajes?atendidos=' + atendidos
      
      axios
        .get(url)
        .then(response => {
          me.mensajes = response.data
          if (me.mensajes.length == 0){
            me.noMensajes = 1
          }else{
            me.noMensajes = 0
          }
          bus.$emit('update-bell');
        })
        .catch(e => {
          console.log(e)
        });
    },

    cambiarEstado(mensaje_id){
      let me = this;

      var url = "/cambiar-estado-mensaje?mensaje_id=" + mensaje_id

      axios 
        .put(url)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: response.data
          })
          this.getMensajes(0)
        })
        .catch(e => {
          console.log(e.data)
        })
    }
  },
  
  beforeCreate(){
      if (this.$router.app.auth == 0 ){
        this.$router.push({ name: 'invitado-invitado'})
      }
  },
  
  created(){
    this.$router.app.mostrarme = 0 
  },
  
  mounted() {
    this.getMensajes(0)
    
    bus.$on('update-anunciate-listado', data =>{
        this.getMensajes(0)
    })
  }
};
</script>