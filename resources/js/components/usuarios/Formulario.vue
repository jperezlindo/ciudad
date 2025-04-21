<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="text-left">
              <h4 slot="header" class="mb-0" v-if="user_id">EDITAR USUARIO</h4>
              <h4 slot="header" class="mb-0" v-else>NUEVO USUARIO</h4>
            </div>
          </div>
          <div class="card-body">
            <form class="form-group">
              <div class="row form-group">
                <div class="col">
                  <small class="font-weight-bold">DNI</small>
                  <input
                    type="text"
                    class="form-control"
                    maxlength="8"
                    id="valDni"
                    v-model="user.dni"
                    :class="valDni"
                    @blur="validarDni()"
                    @keypress="soloNumeros()"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.dni">{{errors.dni}}</small>
                </div>
                <div class="col">
                  <small class="font-weight-bold">APELLIDO</small>
                  <input
                    type="text"
                    class="form-control"
                    maxlength="100"
                    v-model="user.apellido"
                    :class="valApellido"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.apellido">{{errors.apellido}}</small>
                </div>
              </div>
              <div class="row form-group">
                <div class="col">
                  <small class="font-weight-bold">NOMBRE</small>
                  <input
                    type="text"
                    class="form-control"
                    maxlength="100"
                    v-model="user.nombre"
                    :class="valNombre"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.nombre">{{errors.nombre}}</small>
                </div>
                <div class="col">
                  <small class="font-weight-bold">EMAIL</small>
                  <input
                    type="text"
                    class="form-control"
                    maxlength="100"
                    id="valEmail"
                    v-model="user.email"
                    :class="valEmail"
                    @blur="validarEmail()"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.email">{{errors.email}}</small>
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
import bus from "../eventBus";

export default {
  
  props: ['user_id'],

  data() {
    return {
      user: { dni: "", apellido: "", nombre: "", email: "", entidad_id: "" },
      errors: { dni: "", apellido: "", nombre: "", email: "" }
    };
  },
  
  computed: {
    valDni() {
      return {"is-invalid": this.errors.dni};
    },
    valApellido() {
      return {"is-invalid": this.errors.apellido};
    },
    valNombre() {
      return {"is-invalid": this.errors.nombre};
    },
    valEmail() {
      return {"is-invalid": this.errors.email};
    }
  },

  methods: {
    storeUser(id_entidad) {
      let me = this;
      var url = "/crear-usuario";
      me.user.entidad_id = id_entidad;
      
      axios
        .post(url, me.user)
        .then(response => {
          this.$router.push({name:'listado-entidades'});
        })
        .catch(e => {
          console.log(e);
        });
    },

    editUser() {
      let me = this;
      var url = "/editar-usuario?user_id=" + this.user_id;

      axios
        .get(url)
        .then(response => {
          this.user = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    updateUser() {
      if (this.validar()) return;

      let me = this;
      var url = "/actualizar-usuario";

      axios
        .put(url, this.user)
        .then(response => {
          me.$router.push({ name: "listado-usuarios" });
        })
        .catch(e => {
          console.log(e);
        });
    },

    //Validaciones

    validarDni() {
        this.errors.dni = "";
        var url = "/validar-dni-usuario?dni=" + this.user.dni + "&usuario_id=" + this.user_id;
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              this.errors.dni = "El DNI ingresado ya existe";
              document.getElementById("valDni").focus();
            } 
          })
          .catch(e => {
            console.log(e);
          });
    },

    validEmail: function(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },

    validarEmail() {
      this.errors.email = "";
      if (!this.validEmail(this.user.email)) {
        this.errors.email = "El formato de email es incorrecto";
        document.getElementById("valEmail").focus();
      } else {
        var url = "/validar-email-usuario?email=" + this.user.email + "&usuario_id=" + this.user_id;
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              this.errors.email = "El email ingresado ya existe";
              document.getElementById("valEmail").focus();
            } 
          })
          .catch(e => {
            console.log(e);
          });
      }
    },

    soloNumeros(evt) {
      var e = window.event || evt;
      var charCode = e.which || e.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if (window.event)
          //IE
          window.event.returnValue = false;
        //Firefox
        else e.preventDefault();
      }
      return true;
    },

    validar() {

      this.isError = 0;
      this.errors = { dni: "", apellido: "", nombre: "", email: ""};
      var msg = "Dato Obligatorio";

      if (!this.user.dni) this.errors["dni"] = msg;
      if (!this.user.apellido) this.errors["apellido"] = msg;
      if (!this.user.nombre) this.errors["nombre"] = msg;
      if (!this.user.email) this.errors["email"] = msg;

      if (this.errors.dni != '' || this.errors.apellido != '' || this.errors.nombre != '' || this.errors.email != '') this.isError = 1;

      return this.isError;

    }
  },
  
  beforeCreate(){
      if (this.$router.app.auth != 1){
        this.$router.push({ name: 'invitado-invitado'})
      }
  },
  
  mounted() {
    if (this.user_id) {
      this.editUser();
    }

    bus.$on('validar-entidad-usuario', data => {
      if (this.validar()) return;
      bus.$emit('usuarioOK');
    });

    bus.$on("crear-usuario", data => {
      this.storeUser(data);
    });

    bus.$on('actualizar-usuario', data => {
      this.updateUser();
    });

  },

  beforeDestroy() {
    bus.$off();
  }
};
</script>