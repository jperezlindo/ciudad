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
              <div class="col-md-6">
                <input
                  id="buscar"
                  type="text"
                  class="form-control"
                  placeholder="Buscar usuario"
                  aria-label="Buscar"
                  aria-describedby="basic-addon2"
                  v-model="buscar"
                  @change="getUsuarios()"
                />
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
                    <th colspan="2" class="text-center" >Acciones</th>
                    <th scope="col" >                
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="all" @click="getUsuarios()">
                        <label class="custom-control-label" for="all"></label>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="usuario in usuarios" :key="usuario.id">
                    <th>{{usuario.id}}</th>
                    <td>{{usuario.dni}}</td>
                    <td>{{usuario.apellido}}</td>
                    <td>{{usuario.nombre}}</td>
                    <td>{{usuario.email}}</td>
                    <td class="text-center">
                      <router-link type="button" class="btn btn-outline-primary btn-sm" 
                        :to="{ name: 'editar-entidad-usuario', params: {id : usuario.id, quien: 'usuario'}}">
                        <i class="fas fa-edit"></i>
                      </router-link>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-outline-danger btn-sm" @click="nuevaPassword(usuario.id)"><i class="fas fa-key"></i></button>
                    </td>
                    <td>
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
  props: ['auth'],
  data() {
    return {
      buscar: '',
      usuarios: [],
      all:0
    };
  },

  methods: {
    getUsuarios() {
      let me = this;

     if (document.getElementById("all").checked){
        this.all = true;
      }else{
        this.all = 0;
      }

      var url = '/listado-usuarios?all='+this.all+'&buscar='+this.buscar;
      axios
        .get(url)
        .then(response => {
          document.getElementById("buscar").focus();
          me.usuarios = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

    cambiarEstado(user_id){
      let me = this;

      var url = "/cambiar-estado-usuario?user_id=" + user_id;

      axios 
        .put(url)
        .then(response => {
          this.getUsuarios(this.all);
        })
        .catch(error => {

        })
    },
    nuevaPassword(user_id){
        let me = this;
        var url = "/nueva-password?user_id=" + user_id;

        swalConfirm.fire({
            title: '¿Está seguro que desea cambiar la password?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SI',
            cancelButtonText: 'NO',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              axios
                  .put(url, this.user)
                  .then(response => {
                      Toast.fire({
                          icon: 'success',
                          title: 'Password actualizada correctamente'
                      })
                  })
                  .catch(e => {
                      console.log(e);
                  });
            } 
          })
        
    }
  },

  created(){
    this.$router.app.mostrarme = 0 
  },
  
  mounted() {
    this.getUsuarios();
  }
};
</script>