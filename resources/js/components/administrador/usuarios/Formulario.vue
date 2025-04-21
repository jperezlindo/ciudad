<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="text-left">
              <h4 slot="header" class="mb-0" v-if="user_id">EDITAR MIS DATOS</h4>
              <h4 slot="header" class="mb-0" v-else>CREAR NUEVO USUARIO</h4>
            </div>
          </div>
          <div class="card-body">
            <form class="form-group" @submit.prevent="check()">
              <div class="row form-group">
                <div class="col">
                  <small class="font-weight-bold">DNI</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    maxlength="8"
                    id="valDni"
                    v-model="user.dni"
                    :class="valDni"
                    @keypress="soloNumeros()"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.dni">{{errors.dni}}</small>
                </div>
                <div class="col">
                  <small class="font-weight-bold">APELLIDO</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    maxlength="100"
                    v-model="user.apellido"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.apellido">{{errors.apellido}}</small>
                </div>
              </div>
              <div class="row form-group">
                <div class="col">
                  <small class="font-weight-bold">NOMBRE</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    maxlength="100"
                    v-model="user.nombre"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.nombre">{{errors.nombre}}</small>
                </div>
                <div class="col">
                  <small class="font-weight-bold">EMAIL</small>
                  <input
                    required
                    type="email"
                    class="form-control"
                    maxlength="100"
                    id="valEmail"
                    v-model="user.email"
                    :class="valEmail"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.email">{{errors.email}}</small>
                </div>
              </div>
              <!--SPINNER-->
              <div class="row" v-if="imagenCargar">
                <div class="mx-auto ">
                  <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <strong v-if="user_id" class="text-white">Actualizando usuario...</strong>
                    <strong v-else class="text-white">Creando usuario...</strong>
                  </button>
                </div>
              </div>
              <!--FIN SPINNER-->
              <div class="row form-group" v-else>
                <div class="col">
                  <button @click="irAAdministrador()" type="button" class="btn btn-block btn-danger">
                      CANCELAR
                  </button>
                </div>
                <div class="col">
                  <button id="botonSubmit" v-if="user_id" class="btn btn-block btn-success mb-2">ACTUALIZAR</button>
                  <button id="botonSubmit" v-else class="btn btn-block btn-success mb-2">CREAR</button>
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
      entidad_id: null,
      user_id: null,
      user: { dni: "", apellido: "", nombre: "", email: "", entidad_id: "" },
      errors: { dni: "", apellido: "", nombre: "", email: "" },
      imagenCargar: 0
    }
  },

  computed: {
    valDni() {
      return {"is-invalid": this.errors.dni}
    },
    valEmail() {
      return {"is-invalid": this.errors.email}
    }
  },

  methods: {
    storeUser(entidad_id) {
      let me = this
      var url = "/crear-usuario"
      me.imagenCargar = 1;
      me.user.entidad_id = entidad_id
      
      axios
        .post(url, me.user)
        .then(response => {
          me.imagenCargar = 0;
          Toast.fire({
              icon: 'success',
              title: 'El usuario se creo con éxito.'
          })
          me.irAAdministrador()
        })
        .catch(e => {
          console.log(e)
          if (e.response.status == 422) {
            me.imagenCargar = 0;
            var errorsServidor = e.response.data.errors;
            if(errorsServidor.dni) me.errors.dni = errorsServidor.dni[0];
            if(errorsServidor.apellido) me.errors.apellido = errorsServidor.apellido[0];
            if(errorsServidor.nombre) me.errors.nombre = errorsServidor.nombre[0];
            if(errorsServidor.email) me.errors.email = errorsServidor.email[0];
          }
        })
    },

    editUser(id) {
      let me = this
      var url = "/editar-usuario?user_id=" + id

      axios
        .get(url)
        .then(response => {
          this.user = response.data
        })
        .catch(e => {
          console.log(e)
        })
    },

    updateUser() {
      let me = this
      var url = "/actualizar-usuario"
      me.imagenCargar = 1;

      axios
        .put(url, me.user)
        .then(response => {
          me.imagenCargar = 0;
          Toast.fire({
              icon: 'success',
              title: 'Los datos se actualizaron con éxito.'
          })
          me.irAAdministrador()
        })
        .catch(e => {
          console.log(e)
          if (e.response.status == 422) {
            me.imagenCargar = 0;
            var errorsServidor = e.response.data.errors;
            if(errorsServidor.dni) me.errors.dni = errorsServidor.dni[0];
            if(errorsServidor.apellido) me.errors.apellido = errorsServidor.apellido[0];
            if(errorsServidor.nombre) me.errors.nombre = errorsServidor.nombre[0];
            if(errorsServidor.email) me.errors.email = errorsServidor.email[0];
          }
          
        })
    },

    check(){
        let me = this
        document.getElementById('botonSubmit').disabled=true;
        me.validarDni();
    },

    irAAdministrador(){
      let me = this
      me.$router.push({ name: "administrador-administrador"})
    },

    //Validaciones

    validarDni() {
        let me = this;
        me.errors= { dni: "", apellido: "", nombre: "", email: "" }
        var url = "/validar-dni-usuario?dni=" + me.user.dni + "&usuario_id=" + me.user_id
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              me.errors.dni = "El DNI ingresado ya existe"
              document.getElementById('botonSubmit').disabled=false;
              document.getElementById("valDni").focus()
            } else {
              me.validarEmail()
            }
          })
          .catch(e => {
            console.log(e)
          })
    },

    validEmail: function(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email)
    },

    validarEmail() {
      let me = this;
      me.errors= { dni: "", apellido: "", nombre: "", email: "" }
      if (!me.validEmail(me.user.email)) {
        me.errors.email = "El formato de email es incorrecto"
        document.getElementById('botonSubmit').disabled=false;
        document.getElementById("valEmail").focus()
      } else {
        var url = "/validar-email-usuario?email=" + me.user.email + "&usuario_id=" + me.user_id
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              me.errors.email = "El email ingresado ya existe"
              document.getElementById('botonSubmit').disabled=false;
              document.getElementById("valEmail").focus()
            } else {
              if (me.user_id){
                  me.updateUser()
              }else{
                  me.storeUser(me.entidad_id)
              }
            }
          })
          .catch(e => {
            console.log(e)
          })
      }
    },

    soloNumeros(evt) {
      var e = window.event || evt
      var charCode = e.which || e.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if (window.event)
          //IE
          window.event.returnValue = false
        //Firefox
        else e.preventDefault()
      }
      return true
    },
  },
  
  beforeCreate(){
      if (this.$router.app.auth == 0){
        this.$router.push({ name: 'invitado-invitado'})
      }
  },
  
  created(){
    this.user_id = this.$route.params.idUsuario
    this.entidad_id = this.$route.params.idEmpresa
    this.$router.app.mostrarme = 0
  },

  mounted() {
    if (this.user_id) {
      this.editUser(this.user_id)
    }
  },
}
</script>