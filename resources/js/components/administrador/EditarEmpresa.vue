<template>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card border-primary shadow mb-3">
        <div class="card-header">
          <div class="text-left">
            <h4 slot="header" class="mb-0">EDITAR DATOS DE LA EMPRESA</h4>
          </div>
        </div>
        <div class="card-body">
          <form class="form-group" enctype="multipart/form-data" accept="image/*" @submit.prevent="check()">
            <div class="row form-group justify-content-center">
              <div class="" id="preview">
                <img class="rounded d-block" width="300px" height="400px" v-if="urlLogo" :src="urlLogo"/>
                <img class="rounded d-block" width="300px" height="400px" v-else-if="entidad_id" :src="'imagenes/entidades/' + entidad.logo" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFileLang" lang="es" @change="onFileChange">
                  <label class="custom-file-label" for="customFileLang">Logo de la empresa</label>
                </div>
                <div class="alert alert-primary mt-1 text-center" role="alert">
                    <b>(Para una mejor experiencia de visualización, se recomiendan imágenes en posición vertical)</b>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">CUIT</small>
                <input
                  required
                  type="text"
                  class="form-control"
                  maxlength="11"
                  id="valCuit"
                  v-model="entidad.cuit"
                  v-bind:class="valCuit"
                  @keypress="soloNumeros()"
                />
                <small class="text-danger font-weight-bold" v-if="errors.cuit">{{errors.cuit}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Entidad o Servicio</small>
                <input
                  required
                  type="text"
                  class="form-control"
                  maxlength="100"
                  v-model="entidad.nombre"
                />
                <small class="text-danger font-weight-bold" v-if="errors.nombre">{{errors.nombre}}</small>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Categoría</small>
                <select
                  required
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
                  maxlength="30"
                  v-model="entidad.plan_id"
                  disabled
                />
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Dirección</small>
                <input
                  required
                  type="text"
                  class="form-control"
                  maxlength="100"
                  v-model="entidad.direccion"
                />
                <small class="text-danger font-weight-bold" v-if="errors.direccion">{{errors.direccion}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Ubicación</small>
                <input
                  maxlength="200"
                  type="text"
                  class="form-control"
                  placeholder="(Google Maps) Enlace al destino"
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
                  required
                  type="email"
                  class="form-control"
                  maxlength="100"
                  id="valEmailEnt"
                  v-model="entidad.email"
                  v-bind:class="valEmail"
                />
                <small class="text-danger font-weight-bold" v-if="errors.email">{{errors.email}}</small>
              </div>
              <div class="col">
                <small class="font-weight-bold">Celular</small>
                <input
                  required
                  type="text"
                  class="form-control"
                  maxlength="20"
                  v-model="entidad.tel_cel"
                  @keypress="soloNumeros()"
                />
                <small class="text-danger font-weight-bold" v-if="errors.tel_cel">{{errors.tel_cel}}</small>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Descripción</small>
                <textarea class="form-control" rows="5" v-model="entidad.descripcion" ></textarea>
              </div>
            </div>
            <div class="row form-group">
              <div class="col">
                <small class="font-weight-bold">Provincia</small>
                <select
                  required
                  id = "prov"
                  class="form-control"
                  v-model="provincia_id"
                  @change="getLocalidades(provincia_id)"
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
                  required
                  class="form-control"
                  v-model="entidad.localidad_id"
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
              <!--SPINNER-->
              <div class="row" v-if="imagenCargar">
                <div class="mx-auto ">
                  <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <strong class="text-white">Actualizando empresa... (esto puede tardar unos segundos si la imagen es muy pesada)</strong>
                  </button>
                </div>
              </div>
              <!--FIN SPINNER-->
              <div class="row form-group" v-else>
                <div class="col">
                  <button @click="irAAdministrador()" type="button" class="btn btn-block btn-danger mb-2">
                      CANCELAR
                  </button>
                </div>
                <div class="col">
                  <button
                    id="botonSubmit"
                    class="btn btn-block btn-success mb-2"
                    type="submit"
                  >ACTUALIZAR</button>
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

  data() {
    return {
      entidad_id: "",
      entidad: {
        cuit: "",
        nombre: "",
        direccion: "",
        coordenadas: "",
        email: "",
        tel_cel: "",
        descripcion: "",
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
      },
      imagenCargar: 0
    };
  },

  methods: {

    check(){
      let me = this
      document.getElementById('botonSubmit').disabled=true;
      me.validarCuit();
    },

    editEntidad() {
      let me = this
      var url = "/editar-entidad?entidad_id=" + me.entidad_id

      axios
        .get(url)
        .then(response => {
          me.entidad = response.data.entidad
          me.provincia_id = response.data.provincia.id
          me.getLocalidades(me.provincia_id)  
        })
        .catch(e => {
          console.log(e)
        })
    },

    updateEntidad() {
      let me = this
      var url = "/actualizar-entidad"
      me.imagenCargar = 1;

      axios
        .put(url, me.entidad)
        .then(response => {
          me.imagenCargar = 0;
          Toast.fire({
              icon: 'success',
              title: 'Los datos se actualizaron éxito.'
          })
          me.irAAdministrador()
        })
        .catch(e => {
          console.log(e);
          if (e.response.status == 422) {
            me.imagenCargar = 0;
            var errorsServidor = e.response.data.errors;
            if(errorsServidor.cuit) me.errors.cuit = errorsServidor.cuit[0];
            if(errorsServidor.nombre) me.errors.nombre = errorsServidor.nombre[0];
            if(errorsServidor.direccion) me.errors.direccion = errorsServidor.direccion[0];
            if(errorsServidor.tel_cel) me.errors.tel_cel = errorsServidor.tel_cel[0];
            if(errorsServidor.email) me.errors.email = errorsServidor.email[0];
            if(errorsServidor.provincia) me.errors.provincia = errorsServidor.provincia[0];
            if(errorsServidor.localidad_id) me.errors.localidad_id = errorsServidor.localidad_id[0];
          }
        })
    },

    irAAdministrador(){
      let me = this
        me.$router.push({ name: "administrador-administrador" })
    },

    getProvincias() {
      let me = this
      var url = "/listar-provincias"

      axios
        .get(url)
        .then(response => {
          me.provincias = response.data
        })
        .catch(e => {
          console.log(e)
        })
    },

    getLocalidades(idProvincia) {
      let me = this
      var url = "/listar-localidades?provincia_id=" + idProvincia

      axios
        .get(url)
        .then(response => {
          me.localidades = response.data
        })
        .catch(e => {
          console.log(e)
        })
    },

    getCategoriasEntidad(){
      let me = this
      var url = "/categorias-entidad"

      axios
        .get(url)
        .then(response => {
          me.categorias = response.data
        })
        .catch(e => {
          console.log(e)
        })
    },

    //Metodo para previsualizar imagen en vista antes de guardar
    onFileChange(e) {
      let me = this
      let file = e.target.files[0]
      
      let reader = new FileReader()

      reader.onload = (file) => {
        me.urlLogo = reader.result
        me.entidad.logo = me.urlLogo
      }
      reader.readAsDataURL(file)
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
      let me = this;
      me.errors = {
        cuit: "",
        nombre: "",
        direccion: "",
        tel_cel: "",
        email: "",
        provincia: "",
        localidad: "",
      }
      if (!me.validCuit(me.entidad.cuit)) {
        me.errors.cuit = "El cuit ingresado no es valido";
        document.getElementById('botonSubmit').disabled=false;
        document.getElementById("valCuit").focus();
      } else {
        var url = "/validar-cuit-entidad?cuit=" + me.entidad.cuit + "&entidad_id=" +me.entidad_id;
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              me.errors.cuit = "El cuit ingresado ya existe";
              document.getElementById('botonSubmit').disabled=false;
              document.getElementById("valCuit").focus();
            } 
            else{
              me.validarEmail();
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
      let me = this;
      me.errors = {
        cuit: "",
        nombre: "",
        direccion: "",
        tel_cel: "",
        email: "",
        provincia: "",
        localidad: "",
      }
      if (!me.validEmail(me.entidad.email)) {
        me.errors.email = "El formato de email es incorrecto";
        document.getElementById('botonSubmit').disabled=false;
        document.getElementById("valEmailEnt").focus();
      } else {
        var url = "/validar-email-entidad?email=" + me.entidad.email + "&entidad_id=" + me.entidad_id;
        axios
          .get(url)
          .then(response => {
            if (response.data == 0) {
              me.errors.email = "El email ingresado ya existe";
              document.getElementById('botonSubmit').disabled=false;
              document.getElementById("valEmailEnt").focus();
            } else {
              me.updateEntidad();
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
    }
  },

  computed: {
    valCuit() {
      return {"is-invalid": this.errors.cuit}
    },
    valEmail() {
      return {"is-invalid": this.errors.email}
    }
  },
  
  beforeCreate(){
      if (this.$router.app.auth == 0){
        this.$router.push({ name: 'invitado-invitado'})
      }
  },
  
  created(){
    this.entidad_id = this.$route.params.idEmpresa
    this.$router.app.mostrarme = 0
  },

  mounted() {
    this.editEntidad()   
    this.getProvincias()
    this.getCategoriasEntidad()
    
  },
}
</script>