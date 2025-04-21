<template>
<div class="container">
  <div class="row form-group">
    <div class="col">
      <button type="button" class="btn btn-block btn-danger" @click="irAListado">
          CANCELAR
      </button>
    </div>
    <div class="col">
      <button
        class="btn btn-block btn-success"
        type="submit"
        v-if="crear"
        @click.prevent="create()"
      >CREAR</button>
      <button
        class="btn btn-block btn-success"
        type="submit"
        v-else
        @click.prevent="update"
      >ACTUALIZAR</button>
    </div>
  </div>
</div>
</template>
<script>
import bus from "../eventBus";
export default {
  
  props:[
    'quien',
    'crear'
  ],

  data(){
    return{
    };
  },

  methods: {
    create(){
      switch (this.quien) {
        case 'entidadUsuario':
          bus.$emit('validar-entidad-usuario');
          break;
        case 'producto':
          bus.$emit('crear-producto');
          break;
      }
    },

    update(){
      switch (this.quien){
        case 'usuario':
          bus.$emit('actualizar-usuario');
          break;
        case 'entidad':
          bus.$emit('actualizar-entidad');
          break;
        case 'producto':
          bus.$emit('actualizar-producto');
          break;
      }
    },

    irAListado(){

      let me = this;

      switch (this.quien){
        case 'usuario':
          me.$router.push({name:'listado-usuarios'});
          break;
        case 'entidad':
          me.$router.push({name:'listado-entidades'});
          break;
        /*
        case 'producto':
          me.$router.push({name:'listado-productos'});
          break;
        default:
          //Decidir a que parte redireccionar
          me.$router.push({name:'listado-usuarios'});
          */
      }
    }
  },
  
  beforeCreate(){
      if (this.$router.app.auth != 1){
        this.$router.push({ name: 'invitado-invitado'})
      }
  },
  
};
</script>