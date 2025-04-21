<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <entidades-formulario v-if="eu.quien === 'entidad'" :entidad_id="eu.id"></entidades-formulario>
        <usuarios-formulario v-else :user_id="eu.id"></usuarios-formulario>
        <botones-crear-cancelar :quien="eu.quien" crear=""></botones-crear-cancelar>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  
  data() {
    return {
      eu: {id : this.$route.params.id, quien : this.$route.params.quien}
    }
  },

  beforeCreate(){
      if (this.$router.app.auth != 1){
          this.$router.push({ name: 'invitado-invitado'})
      }
  }
};
</script>