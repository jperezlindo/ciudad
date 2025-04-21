<template>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card border-primary shadow mb-3">
        <div class="card-header">
          <div class="text-left">
            <h4 slot="header" class="mb-0" v-if="entidad_id">EDITAR ENTIDAD</h4>
            <h4 slot="header" class="mb-0" v-else>NUEVA ENTIDAD O SERVICIO</h4>
          </div>
        </div>
        <div class="card-body">
          <form class="form-group" enctype="multipart/form-data" accept="image/*">
            <div class="row form-group justify-content-center">
              <div class="" id="preview">
                <img class="rounded mx-auto d-block" width="200px" v-if="urlLogo" :src="urlLogo"/>
                <img class="rounded mx-auto d-block" width="200px" v-else-if="entidad_id" :src="'imagenes/entidades/' + entidad.logo" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFileLang" lang="es" @change="onFileChange">
                  <label class="custom-file-label" for="customFileLang">Logo de la entidad</label>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">CUIT/CUIL</small>
                <input
                  type="text"
                  class="form-control"
                  maxlength="11"
                  id="valCuit"
                  v-model="entidad.cuit"
                  v-bind:class="valCuit"
                  @blur="validarCuit()"
                  @keypress="soloNumeros()"
                />
                <small class="text-danger font-weight-bold" v-if="errors.cuit">{{errors.cuit}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Entidad o Servicio</small>
                <input
                  type="text"
                  class="form-control"
                  maxlength="100"
                  v-model="entidad.nombre"
                  v-bind:class="valNombre"
                />
                <small class="text-danger font-weight-bold" v-if="errors.nombre">{{errors.nombre}}</small>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Categoría</small>
                <select
                  class="form-control"
                  v-model="entidad.categoria_entidad_id"
                >
                  <option value disabled>Categoria</option>
                  <option
                    v-for="categoria in categorias"
                    :key="categoria.id"
                    :value="categoria.id"
                  >{{categoria.nombre}}</option>
                </select>
              </div>
              <div class="col">
                <small class="font-weight-bold">Plan</small>
                <input
                  type="number"
                  class="form-control"
                  max="10000"
                  min="0"
                  v-model="entidad.plan_id"
                />
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Dirección</small>
                <input
                  type="text"
                  class="form-control"
                  maxlength="100"
                  v-model="entidad.direccion"
                  v-bind:class="valDireccion"
                />
                <small class="text-danger font-weight-bold" v-if="errors.direccion">{{errors.direccion}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Coordenadas</small>
                <input
                  type="text"
                  class="form-control"
                  v-model="entidad.coordenadas"
                />
                <span
                  class="badge badge-pill badge-danger"
                  v-if="errors.coordenadas"
                >{{errors.coordenadas}}</span>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Email</small>
                <input
                  type="text"
                  class="form-control"
                  maxlength="100"
                  id="valEmailEnt"
                  v-model="entidad.email"
                  v-bind:class="valEmail"
                  @blur="validarEmail()"
                />
                <small class="text-danger font-weight-bold" v-if="errors.email">{{errors.email}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Celular</small>
                <input
                  type="text"
                  class="form-control"
                  maxlength="20"
                  v-model="entidad.tel_cel"
                  v-bind:class="valTelcel"
                  @keypress="soloNumeros()"
                />
                <small class="text-danger font-weight-bold" v-if="errors.tel_cel">{{errors.tel_cel}}</small>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Provincia</small>
                <select
                  id = "prov"
                  class="form-control"
                  v-model="provincia_id"
                  @change="getLocalidades(provincia_id)"
                  v-bind:class="valProvincia"
                >                   
                  <option
                    v-for="provincia in provincias"
                    :key="provincia.id"
                    :value="provincia.id"
                  >{{provincia.nombre}}</option>
                </select>
                <small class="text-danger font-weight-bold" v-if="errors.provincia">{{errors.provincia}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Localidad</small>
                <select
                  class="form-control"
                  v-model="entidad.localidad_id"
                  v-bind:class="valLocalidad"
                >
                  <option value disabled>Localidades</option>
                  <option
                    v-for="localidad in localidades"
                    :key="localidad.id"
                    :value="localidad.id"
                  >{{localidad.nombre}}</option>
                </select>
                <small class="text-danger font-weight-bold" v-if="errors.localidad">{{errors.localidad}}</small>
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
  props: ['entidad_id'],

  data() {
    return {
      //entidad_id: this.$route.params.idEntidad,
      entidad: {
        cuit: "",
        nombre: "",
        direccion: "",
        coordenadas: "",
        email: "",
        tel_cel: "",
        localidad_id: "",
        categoria_entidad_id: "",
        logo: ""
      },
      provincia: [],
      categorias: [],
      urlLogo: "",
      provincias: [],
      provincia_id: "",
      localidades: [],
      crear: "",
      errors: {
        cuit: "",
        nombre: "",
        direccion: "",
        tel_cel: "",
        email: "",
        provincia: "",
        localidad: "",
      }
    };
  },

  methods: {
    storeEntidad() {
      let me = this;
      var url = "/crear-entidad";

      axios
        .post(url, this.entidad)
        .then(response => {
          bus.$emit("crear-usuario", response.data.id);
        })
        .catch(e => {
          console.log(e);
        });
    },

    editEntidad() {
      let me = this;
      var url = "/editar-entidad?entidad_id=" + this.entidad_id;

      axios
        .get(url)
        .then(response => {
          me.entidad = response.data.entidad;
          me.provincia_id = response.data.provincia.id;
          this.getLocalidades(me.provincia_id);  
        })
        .catch(e => {
          console.log(e);
        });
    },

    updateEntidad() {
      if (this.validar()) return ;

      let me = this;

      var url = "/actualizar-entidad";

      axios
        .put(url, this.entidad)
        .then(response => {
          me.$router.push({ name: "listado-entidades" });
        })
        .catch(e => {
          console.log(e);
        });
    },

    getProvincias() {
      let me = this;
      var url = "/listar-provincias";

      axios
        .get(url)
        .then(response => {
          me.provincias = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    getLocalidades(idProvincia) {
      let me = this;
      var url = "/listar-localidades?provincia_id=" + idProvincia;

      axios
        .get(url)
        .then(response => {
          me.localidades = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    getCategoriasEntidad(){
      let me = this;
      var url = "/categorias-entidad";

      axios
        .get(url)
        .then(response => {
          me.categorias = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    //Metodo para previsualizar imagen en vista antes de guardar
    onFileChange(e) {
      let me = this;
      let file = e.target.files[0];
      
      let reader = new FileReader();

      reader.onload = (file) => {
        me.urlLogo = reader.result;
        me.entidad.logo = me.urlLogo;
      }
      reader.readAsDataURL(file);
    },

    //VALIDACIONES

    validCuit(cuit) {
      var cuit = cuit.trim();
      if (cuit.length != 11) {
        return false;
      }
      var acumulado = 0;
      var digitos = cuit.split("");
      var digito = digitos.pop();
      for (var i = 0; i < digitos.length; i++) {
        acumulado += digitos[9 - i] * (2 + (i % 6));
      }
      var verif = 11 - (acumulado % 11);
      if (verif == 11) {
        verif = 0;
      }
      return digito == verif;
    },
    validarCuit() {
      this.errors.cuit = "";
      if (!this.validCuit(this.entidad.cuit)) {
        this.errors.cuit = "El cuit ingresado no es valido";
        document.getElementById("valCuit").focus();
      } else {
        let me = this;
        var url = "/validar-cuit-entidad?cuit=" + this.entidad.cuit + "&entidad_id=" +this.entidad_id;
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              this.errors.cuit = "El cuit ingresado ya existe";
              document.getElementById("valCuit").focus();
            } 
          })
          .catch(e => {
            console.log(e);
          });
      }
    },
    validEmail: function(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    validarEmail() {
      this.errors.email = "";
      if (!this.validEmail(this.entidad.email)) {
        this.errors.email = "El formato de email es incorrecto";
        document.getElementById("valEmailEnt").focus();
      } else {
        let me = this;
        var url = "/validar-email-entidad?email=" + this.entidad.email + "&entidad_id=" + this.entidad_id;
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              this.errors.email = "El email ingresado ya existe";
              document.getElementById("valEmailEnt").focus();
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
        if (window.event) //IE
          window.event.returnValue = false; //Firefox
        else e.preventDefault();
      }
      return true;
    },
    validar() {

      this.isError = 0;
      this.errors = { cuit: "", nombre: "", direccion: "", tel_cel: "", email: "", provincia: "", localidad: ""};
      var msg = "Dato Obligatorio";

      if (!this.entidad.cuit) this.errors["cuit"] = msg;
      if (!this.entidad.nombre) this.errors["nombre"] = msg;
      if (!this.entidad.direccion) this.errors["direccion"] = msg;
      if (!this.entidad.tel_cel) this.errors["tel_cel"] = msg;
      if (!this.entidad.email) this.errors["email"] = msg;
      if (!this.provincia_id) this.errors["provincia"] = msg;
      if (!this.entidad.localidad_id) this.errors["localidad"] = msg;

      if (this.errors.cuit != '' || this.errors.nombre != '' || this.errors.direccion != '' || this.errors.tel_cel != ''
        || this.errors.email != '' || this.errors.provincia != '' || this.errors.localidad != '') this.isError = 1;

      return this.isError;
      
    }
  },

  computed: {
    valCuit() {
      return {"is-invalid": this.errors.cuit};
    },
    valNombre() {
      return {"is-invalid": this.errors.nombre};
    },
    valDireccion() {
      return {"is-invalid":this.errors.direccion};
    },
    valEmail() {
      return {"is-invalid": this.errors.email};
    },
    valTelcel() {
      return {"is-invalid": this.errors.tel_cel};
    },
    valProvincia() {
      return {"is-invalid":this.errors.provincia};
    },
    valLocalidad() {
      return {"is-invalid":this.errors.localidad};
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
    if (this.entidad_id) {
      this.editEntidad();   
    }

    this.getProvincias();
    this.getCategoriasEntidad();

    bus.$on("validar-entidad-usuario", data => {
      if (this.validar()) return;
      bus.$emit("entidadOK");
    });

    bus.$on("crear-entidad", data => {
      this.storeEntidad();
    });

    bus.$on('actualizar-entidad',data => {
      this.updateEntidad();
    });
    
  },

  beforeDestroy() {
    bus.$off();
  }
};
</script>