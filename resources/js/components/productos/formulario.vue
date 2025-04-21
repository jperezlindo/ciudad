<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary shadow mb-3">
          <div class="card-header">
            <div class="text-left">
              <h4 slot="header" class="mb-0" v-if="producto_id">EDITAR PRODUCTO</h4>
              <h4 slot="header" class="mb-0" v-else>NUEVO PRODUCTO O SERVICIO</h4>
            </div>
          </div>
          <div class="card-body">
            <form class="form-group" enctype="multipart/form-data" accept="image/*" @submit.prevent="check()">
              <div class="row form-group justify-content-center">
                <div id="preview">
                  <img class="rounded mx-auto d-block" width="300px" height="400px" v-if="urlImagen" :src="urlImagen"/>
                  <img class="rounded mx-auto d-block" width="300px" height="400px" v-else-if="producto_id" :src="'imagenes/productos/' + producto.imagen" />                  
                </div>
              </div>
              <div class="row form-group">
                <div class="col">
                  <div class="custom-file">
                    <input
                      type="file"
                      class="custom-file-input"
                      id="customFileLang"
                      lang="es"
                      @change="onFileChange"
                    />
                    <label class="custom-file-label" for="customFileLang">Imagen del Producto</label>
                  </div>
                  <div class="alert alert-primary mt-1 text-center" role="alert">
                      <b>(Para una mejor experiencia de visualización, se recomiendan imágenes en posición vertical)</b>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-2">
                  <small class="font-weight-bold">Código*</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    v-model="producto.codigo"
                    maxlength="100"
                    id="valCodigo"
                    :class="valCodigo"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.codigo">{{errors.codigo}}</small>
                </div>
                <div class="col-md-4">
                  <small class="font-weight-bold">Nombre*</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    maxlength="100"
                    v-model="producto.nombre"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.nombre">{{errors.nombre}}</small>
                </div>
                <div class="col-md-4">
                  <small class="font-weight-bold">Marca/Rubro*</small>
                  <input
                    required
                    type="text"
                    class="form-control"
                    maxlength="30"
                    v-model="producto.marca"
                  />
                  <small class="text-danger font-weight-bold" v-if="errors.marca">{{errors.marca}}</small>
                </div>
                <div class="col-md-2">
                  <small class="font-weight-bold">Precio</small>
                  <input
                    type="number"
                    class="form-control"
                    maxlength="30"
                    v-model="producto.precio"
                    step="0.01"
                    min="0"
                    max="1000000"
                  />
                </div>
              </div>
              <div class="row form-group">
                <div class="col">
                  <small class="font-weight-bold">Descripción</small>
                  <textarea
                    type="text"
                    class="form-control"
                    maxlength="250"
                    v-model="producto.descripcion"
                  />
                </div>
              </div>
              <!--SPINNER-->
              <div class="row" v-if="imagenCargar">
                <div class="mx-auto ">
                  <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <strong class="text-white">Guardando producto... (esto puede tardar unos segundos si la imagen es muy pesada)</strong>
                  </button>
                </div>
              </div>
              <!--FIN SPINNER-->
              <div class="row form-group" v-else>
                <div class="col">
                  <button type="button" class="btn btn-block btn-danger" @click="irAListado()">CANCELAR</button>
                </div>
                <div class="col">
                  <button id="botonSubmit" v-if="producto_id" class="btn btn-block btn-success">ACTUALIZAR</button>
                  <button id="botonSubmit" v-else class="btn btn-block btn-success">CREAR</button>
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
        crear: "",
        entidad_id: null,
        producto_id: null,
        producto: {
          codigo: "",
          nombre: "",
          marca: "",
          precio: "",
          descripcion: "",
          imagen: ""
        },
        total: "",
        urlImagen: "",
        errors: {codigo:"", nombre:"", marca:""},
        imagenCargar: 0
      };
  },

  computed: {
    valCodigo() { 
      return {"is-invalid": this.errors.codigo}; 
      },
  },

  beforeCreate(){
      if (this.$router.app.auth == 0 ){
        this.$router.replace({ name: 'invitado-invitado'})
      }
  },
  
  created(){
    this.$router.app.mostrarme = 0
    this.producto_id = this.$route.params.idProducto
    this.entidad_id = this.$route.params.idEntidad
  },

  methods: {

    check(){
      document.getElementById('botonSubmit').disabled=true;
      this.validarCodigo();
    },

    storeProducto() {
      let me = this;
      var url = "/crear-producto";
      me.imagenCargar = 1;
      axios
        .post(url, me.producto)
        .then(response => {
          me.imagenCargar = 0;
          swalConfirm.fire({
            title: '¿Desea agregar mas productos?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'SI',
            cancelButtonText: 'NO',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              me.producto = {
                codigo: "",
                nombre: "",
                marca: "",
                precio: "",
                descripcion: "",
                imagen: ""
              };
              me.urlImagen = ""
              me.verificarPlan()
            } else {
              me.irAListado()
            }
          })
        })
        .catch(e => {
          console.log(e);
          if (e.response.status == 422) {
            me.imagenCargar = 0;
            var errorsServidor = e.response.data.errors;
            if(errorsServidor.codigo) me.errors.codigo = errorsServidor.codigo[0];
            if(errorsServidor.nombre) me.errors.nombre = errorsServidor.nombre[0];
            if(errorsServidor.marca) me.errors.marca = errorsServidor.marca[0];
          }
        });
    },

    updateProducto() {
      let me = this;
      var url = "/actualizar-producto?producto_id=" + me.producto_id;
      me.imagenCargar = 1;

      axios
        .put(url, me.producto)
        .then(response => {
          me.imagenCargar = 0;
          Toast.fire({
              icon: 'success',
              title: 'Los datos se actualizaron con éxito.'
          })
          me.irAListado();
        })
        .catch(e => {
          console.log(e);
          if (e.response.status == 422) {
            me.imagenCargar = 0;
            var errorsServidor = e.response.data.errors;
            if(errorsServidor.codigo) me.errors.codigo = errorsServidor.codigo[0];
            if(errorsServidor.nombre) me.errors.nombre = errorsServidor.nombre[0];
            if(errorsServidor.marca) me.errors.marca = errorsServidor.marca[0];
          }
        });
    },

    editProducto() {
      let me = this;

      var url = "/editar-producto?producto_id=" + me.producto_id;
      axios
        .get(url)
        .then(response => {
          me.producto = response.data;
        })
        .catch(e => {
          console.log(e);
        });
    },

    verificarPlan(){
      let me = this;

      var url = '/verificar-plan';

      axios.get(url)
        .then(response => {
          if (response.data == 1){
            Swal.fire(
              '¡Lo sentimos!',
              'Tu plan no te permite cargar más productos. Si querés podés eliminar algúnos para crear otros nuevos.',
              'warning'
            );
            me.irAListado();
          }          
        })
        .catch(e => {
          console.log(e);
        })
    },

    //Metodo para previsualizar imagen en vista antes de guardar
    onFileChange(e) {
      let me = this;
      let file = e.target.files[0];
      let reader = new FileReader();
      
      reader.readAsDataURL(file);
      reader.onload = file => {
        me.urlImagen = reader.result;
        me.producto.imagen = me.urlImagen;
      };
      
    },

    irAListado(){
      let me = this;
      me.$router.push({name:'listado-productos'});
    },
    //VALIDACIONES 

    validarCodigo() {
      let me = this;
      me.errors = {codigo:"", nombre:"", marca:""}
      var url = "/validar-codigo-producto?codigo=" + this.producto.codigo + "&producto_id=" + this.producto_id;
      axios.get(url)
        .then(response => {
          if (response.data == 0) {
            this.errors.codigo = "El codigo ingresado ya existe";
            document.getElementById('botonSubmit').disabled=false;
            document.getElementById('valCodigo').focus();
          }else{
            if(this.producto_id){
              this.updateProducto();
            } else {
              this.storeProducto();
            }
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
  },

  beforeCreate(){
      if (this.$router.app.auth == 0){
          this.$router.push({ name: 'invitado-invitado'})
      }
      this.$router.app.mostrarme = 0
  },

  mounted() {
    if (this.producto_id) {
      this.editProducto()
    }

    if (!this.producto_id) {
      this.verificarPlan()
    }
  }
};
</script>