<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>LISTADO DE CATEGORIAS (ENTIDAD)</h3>
              </div>
              <div class="col-md-6 text-right">
                <router-link :to="{ name: 'crear-categoria-entidad'}" class="btn btn-primary">
                  Nueva Categoría
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
                    <th scope="col">Descripción</th>
                    <th scope="col">Categoría (Super)</th>
                    <th scope="col">Editar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="cat_ent in categorias_entidad" :key="cat_ent.id">
                    <th>{{cat_ent.id}}</th>
                    <td>{{cat_ent.nombre}}</td>
                    <th>{{cat_ent.descripcion}}</th>
                    <td v-if="cat_ent.categoria_id == 1">COMERCIOS</td>
                    <td v-else-if="cat_ent.categoria_id == 2">SERVICIOS</td>
                    <td v-else-if="cat_ent.categoria_id == 3">TURISMO</td>
                    <td v-else>GASTRONOMIA</td>
                    <td>
                      <router-link type="button" class="btn btn-outline-primary btn-sm" 
                        :to="{ name: 'editar-categoria-entidad', params: {idCatEnt : cat_ent.id}}">
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
      categorias_entidad: [],
    };
  },

  methods: {
    getCategoriasEntidad() {
      let me = this;

      var url = '/listado-categorias-entidad';
      axios
        .get(url)
        .then(response => {
          me.categorias_entidad = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },

  },
  
  created(){
    this.$router.app.mostrarme = 0
  },

  mounted() {
    this.getCategoriasEntidad();
  }
};
</script>