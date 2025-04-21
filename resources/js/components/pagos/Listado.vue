<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>LISTADO DE PAGOS ENTIDADES</h3>
              </div>
              <div class="col-md-6">
                 <input
                   id="buscar"
                   type="text"
                   class="form-control"
                   placeholder="Buscar Entidad o Servicio"
                   aria-label="Buscar"
                   aria-describedby="basic-addon2"
                   v-model="buscar"
                   @change="getPagos()"
                 />
              </div>
            </div>
          </div>
          <div class="card-body text-primary">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Empresa</th>
                  <th scope="col">Telefono</th>
                  <th scope="col">Email</th>
                  <th scope="col">Utimo Pago</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Prox. pago</th>
                  <th class="text-center" scope="col" >Plan</th>
                  <th class="text-center" scope="col" >Pago</th>
                  <th class="text-center" scope="col" >Mensaje</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="entidad in entidades" :key="entidad.id">
                  <th>{{entidad.entidad.id}}</th>
                  <td>{{entidad.entidad.nombre}}</td>
                  <td>{{entidad.entidad.tel_cel}}</td>
                  <td>{{entidad.entidad.email}}</td>
                  <td>{{entidad.ultimo_pago}}</td>
                  <td>$ {{entidad.precio_pago}}</td>
                  <td>{{entidad.proximo_pago}}</td>
                  <td class="text-center">{{entidad.entidad.plan_id}}</td>
                  <td class="text-center">
                    <router-link type="button" class="btn btn-outline-primary btn-sm" 
                      :to="{ name: 'crear-pago', params: {idEntidad : entidad.entidad.id, entidad: entidad.entidad.nombre}}">
                      <i class="fas fa-plus"></i>
                    </router-link>
                  </td>
                  <td class="text-center">
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="far fa-paper-plane"></i>
                    </a>
                  </td>

                  
                </tr>
              </tbody>
            </table>
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
      buscar:'',
      entidades: [],
      all:0,
    };
  },

  methods: {
    getPagos() {
      let me = this;

      var url = '/listado-pagos?all='+this.all+'&buscar='+this.buscar;
      
      axios
        .get(url)
        .then(response => {
          document.getElementById("buscar").focus();
          me.entidades = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    cambiarEstado(entidad_id){
      let me = this;

      var url = "/cambiar-estado-entidad?entidad_id=" + entidad_id;

      axios 
        .put(url)
        .then(response => {
          this.getEntidades();
        })
        .catch(e => {
          console.log(e);
        })
    }
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
    this.getPagos();
  }
};
</script>