<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>LISTADO DE REDES</h3>
              </div>
              <div class="col-md-6 text-right">
                <router-link :to="{ name: 'crear-redes'}" class="btn btn-primary">
                  Nueva Red
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
                    <th scope="col">Nombre</th>
                    <th scope="col">Icono</th>
                    <th scope="col">Editar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="red in redes" :key="red.id">
                    <th>{{red.id}}</th>
                    <td>{{red.nombre}}</td>
                    <td v-html="red.icono"></td>
                    <td>
                      <router-link type="button" class="btn btn-outline-primary btn-sm" 
                        :to="{ name: 'editar-red', params: {idRed : red.id}}">
                        <i class="fas fa-edit"></i>
                      </router-link>
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
      redes: [],
    };
  },

  methods: {
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
    this.getRedes();
  }
};
</script>