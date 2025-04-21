<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>LISTADO DE USUARIOS</h3>
              </div>
              <div class="col-md-6 text-right">
                <router-link type="button" class="btn btn-outline-primary" 
                  :to="{ name: 'administrador-usuarios-formulario', params: {idEmpresa: entidad_id}}">
                  Nuevo Usuario
                </router-link>
              </div>
            </div>
          </div>
          <div class="card-body text-primary">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">D.N.I</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-center">Activar/Desactivar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="usuario in usuarios" :key="usuario.id">
                    <td>{{usuario.entidad_id}}</td>
                    <td>{{usuario.dni}}</td>
                    <td>{{usuario.apellido}}</td>
                    <td>{{usuario.nombre}}</td>
                    <td>{{usuario.email}}</td>
                    <td class="text-center">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                        v-bind:id="usuario.id" 
                        v-bind:checked="(usuario.activo ? true : '')"
                        @click="cambiarEstado(usuario.id)"/>
                        <label class="custom-control-label" v-bind:for="usuario.id"></label>
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
</template>

<script>
export default {
  
  data() {
    return {
        entidad_id: null,
        buscar: 'editar-mi-perfil',
        usuarios: [],
    }
  },

  methods: {
    getUsuarios() {
      let me = this

      var url = '/listado-usuarios'
      axios
        .get(url, {params: {
            entidad_id: me.entidad_id,
            buscar: me.buscar,
        }})
        .then(response => {
          me.usuarios = response.data
        })
        .catch(error => {
          console.log(error)
        })
    },

    cambiarEstado(user_id){
      let me = me

      var url = "/cambiar-estado-usuario?user_id=" + user_id

      axios 
        .put(url)
        .then(response => {
            Toast.fire({
                icon: 'success',
                title: response.data
            })

            me.getUsuarios()
        })
        .catch(error => {

        })
    }
  },

  beforeCreate(){
      if (this.$router.app.auth == 0){
        this.$router.push({ name: 'invitado-invitado'})
      }
  },

  created(){
      this.entidad_id = this.$route.params.idEmpresa
      this.$router.app.mostrarme = 0
  },

  mounted() {
    this.getUsuarios()
  }
}
</script>