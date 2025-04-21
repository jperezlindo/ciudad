<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary shadow mb-3">
          <div class="card-header">
            <div class="text-left">
              <h4 slot="header" class="mb-0" v-if="cat_ent_id">EDITAR CATEGORIA ENTIDAD</h4>
              <h4 slot="header" class="mb-0" v-else>NUEVA CATEGORIA ENTIDAD</h4>
            </div>
          </div>
          <div class="card-body">
            <form class="form-group" @submit.prevent="check()">
              <div class="row form-group">
                <div class="col-md-4">
                  <small class="font-weight-bold">Nombre</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    v-model="cat_ent.nombre"
                    maxlength="100"
                  />
                </div>
                <div class="col-md-4">
                  <small class="font-weight-bold">Descripción</small>
                  <input
                    type="text"
                    class="form-control"
                    v-model="cat_ent.descripcion"
                    maxlength="100"
                  />
                </div>
                <div class="col-md-4">
                  <small class="font-weight-bold">Categoría</small>
                  <select
                    required
                    class="form-control"
                    v-model="cat_ent.categoria_id"
                    >                   
                    <option
                        v-for="cat in categorias"
                        :key="cat.id"
                        :value="cat.id"
                    >{{cat.nombre}}</option>
                   </select>
                </div>
              </div>
                <div class="row">
                    <div class="col-md-6">
                        <button @click="irAListado()" type="button" class="btn btn-block btn-danger">CANCELAR</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-block btn-success" v-if="cat_ent_id">Actualizar</button>
                        <button class="btn btn-block btn-success" type="submit" v-else>CREAR</button>
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
      cat_ent_id: this.$route.params.idCatEnt,
      cat_ent: {
        nombre: "",
        descripcion: "",
        categoria_id: ""
       },
      categorias: [
        {id: 1, nombre: "COMERCIOS"},
        {id: 2, nombre: "SERVICIOS"},
        {id: 3, nombre: "TURISMO"},
        {id: 4, nombre: "GASTRONOMIA"}
      ]
    };
  },

  methods: {
    storeCategoriaEntidad() {

      let me = this;

      var url = "/crear-categoria-entidad";

      axios
        .post(url, me.cat_ent)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: 'Categoría entidad creada con éxito..'
          })
          me.irAListado();
        })
        .catch(e => {
          console.log(e);
          
        });
    },

    updateCategoriaEntidad() {
      let me = this;

      var url = "/actualizar-categoria-entidad?cat_ent_id=" + me.cat_ent_id;

      axios
        .put(url, me.cat_ent)
        .then(response => {
          Toast.fire({
              icon: 'success',
              title: 'Categoria entidad actualizada con éxito..'
          })
          me.irAListado();
        })
        .catch(e => {
          console.log(e);
          
        });
    },

    editCategoriaEntidad() {
      let me = this;

      var url = "/editar-categoria-entidad?cat_ent_id=" + me.cat_ent_id;
      axios
        .get(url)
        .then(response => {
          me.cat_ent = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    irAListado(){
      let me = this;
      me.$router.push({ name: "listado-categorias-entidad" });
    },

    check(){
      if(this.cat_ent_id){
        this.updateCategoriaEntidad();
      } else {
        this.storeCategoriaEntidad();
      }
    }

  },

  created(){
    this.$router.app.mostrarme = 0
  },
  mounted() {
    if (this.cat_ent_id) {
      this.editCategoriaEntidad();
    };
  }
};
</script>