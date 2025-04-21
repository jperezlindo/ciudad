<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>LISTADO DE ENTIDADES</h3>
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
                   @change="getEntidades()"
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
                    <th scope="col">C.U.I.T</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Email</th>
                    <th class="text-center" scope="col" >Aplicar</th>
                    <th class="text-center" scope="col" >Plan</th>
                    <th class="text-center" scope="col" >Editar</th>
                    <th class="text-center" scope="col" >Pago</th>
                    <th scope="col" >                
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="all" @click="getEntidades()">
                        <label class="custom-control-label" for="all"></label>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="entidad in entidades" :key="entidad.id">
                    <th>{{entidad.id}}</th>
                    <th>{{entidad.cuit}}</th>
                    <td>{{entidad.nombre}}</td>
                    <td>{{entidad.email}}</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-outline-primary btn-sm" @click="aplicarPlan(entidad.id, entidad.plan_id)">
                        <i class="far fa-play-circle"></i>
                      </button>
                    </td>
                    <td class="text-center">{{entidad.plan_id}}</td>
                    <td class="text-center">
                      <router-link type="button" class="btn btn-outline-primary btn-sm" 
                        :to="{ name: 'editar-entidad-usuario', params: {id : entidad.id, quien : 'entidad'}}">
                        <i class="fas fa-edit"></i>
                      </router-link>
                    </td>
                    <td class="text-center">
                      <router-link type="button" class="btn btn-outline-success btn-sm" 
                        :to="{ name: 'crear-pago', params: {idEntidad : entidad.id, entidad: entidad.nombre}}">
                        <i class="fas fa-plus"></i>
                      </router-link>
                    </td>
                    <td>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                        v-bind:id="entidad.id" 
                        v-bind:checked="(entidad.activo ? true : '')"
                        @click="cambiarEstado(entidad.id)"/>
                        <label class="custom-control-label" v-bind:for="entidad.id"></label>
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
  props:['auth'],

  data() {
    return {
      buscar:'',
      entidades: [],
      all:0
    };
  },

  methods: {
    getEntidades() {
      let me = this;

      if (document.getElementById("all").checked){
        this.all = true;
      }else{
        this.all = 0;
      }

      var url = '/listado-entidades?all='+this.all+'&buscar='+this.buscar;
      
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
    },

    aplicarPlan(entidad_id, plan_id){
      let me = this;
      var url = '/aplicar-plan-activo?entidad_id=' + entidad_id + '&plan_id=' + plan_id;

      swalConfirm.fire({
          title: '¿Está seguro que desea aplicar el plan?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'SI',
          cancelButtonText: 'NO',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            axios.put(url)
              .then(response => {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'El nuevo plan se aplicó con éxito.',
                  showConfirmButton: false,
                  timer: 1500
                })
              })
              .catch(e => {
                console.log(e);
              })
          } 
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
    this.getEntidades();
  }
};
</script>