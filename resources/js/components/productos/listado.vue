<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="alert alert-info mt-2" role="alert">
          Aquí podrás ver el listado de los productos o servicios que vendés u ofrecés.
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card border-primary mb-3 shadow">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>MIS PRODUCTOS</h3>
              </div>
              <div class="col-md-4">
                <input
                  id = "buscar"
                  type="text"
                  class="form-control mb-1"
                  placeholder="Buscar Producto o Servicio"
                  aria-label="Buscar"
                  aria-describedby="basic-addon2"
                  v-model = "buscar"
                  @change="getProductos(false)"
                />
              </div>
              <div class="col-md-2 text-right mt-2">
                <a @click="getProductosAll(false)" href="#">Activos</a>|<a @click="getProductosAll(1)" href="#">Todos</a>
              </div>
            </div>
          </div>
          <div class="card-body text-primary">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Marca/Categoría</th>
                    <th scope="col">Precio</th>
                    <th scope="col" class="text-center">Editar</th>
                    <th scope="col" class="text-center">Eliminar</th>
                    <th scope="col" class="text-center">               
                      Desactivar/Activar <br>
                    </th>
                  </tr>
                </thead>
                <tbody>       
                  <tr v-for="producto in productos" :key="producto.id">
                    <th>{{producto.codigo}}</th>
                    <td>{{producto.nombre}}</td>
                    <td>{{producto.marca}}</td>
                    <td v-if="producto.precio">$ {{producto.precio}}</td>
                    <td v-else>-</td>
                    <td class="text-center">
                      <router-link type="button" class="btn btn-outline-primary btn-sm" 
                        :to="{ name: 'editar-productos', params: {idProducto : producto.id}}">
                        <i class="fas fa-edit"></i>
                      </router-link>
                    </td>
                     <td class="text-center">
                      <button @click="deleteProducto(producto.id)" class="btn btn-outline-danger btn-sm" id="botonEliminar">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                    <td class="text-center">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                        :id="producto.id" 
                        :checked="(producto.activo ? true : '')"
                        @click="cambiarEstado(producto.id)"/>
                        <label class="custom-control-label" v-bind:for="producto.id"></label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--SPINNER-->
            <div class="row" v-if="!productos.length">
              <div class="mx-auto ">
                <button class="btn btn-primary" type="button" disabled>
                  <div v-if="!noProductos">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <strong class="text-white">Cargando productos...</strong>
                  </div>
                  <div v-else>
                    <strong class="text-white">Ningún producto para mostrar</strong>
                  </div>
                </button>
              </div>
            </div>
            <!--FIN SPINNER-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props: ['auth'],
  data(){
      return{
        buscar: '',
        productos: [],
        all: '',
        noProductos: ''
      };
  },

  methods: {

      getProductosAll(valor){
        let me = this;
        me.buscar= '';
        me.getProductos(valor);
      },

      getProductos(all){
          let me = this;

          var url = '/listado-productos?all='+all+'&buscar='+me.buscar
          
          axios
              .get(url)
              .then(response => {
                var data = response.data

                if (data.length == 0){
                    me.noProductos = 1
                    me.productos = data
                }else{
                    me.noProductos = 0
                    me.productos = data
                }
              })
              .catch(e => {
                console.log(e);
              })
      },

      deleteProducto(producto_id) {
        document.getElementById('botonEliminar').disabled=true;

        let me = this;
        var url = "/eliminar-producto?producto_id=" + producto_id;

        swalConfirm.fire({
            title: '¿Está seguro que desea eliminar este producto para siempre?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SI',
            cancelButtonText: 'NO',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              axios
                .delete(url)
                .then(response => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Producto eliminado correctamente'
                    })
                    document.getElementById('botonEliminar').disabled=false;
                    me.getProductos(false);
                })
                .catch(e => {
                    console.log(e);
                });
            } else {
              document.getElementById('botonEliminar').disabled=false;
            }
          })   
      },

      cambiarEstado(producto_id){
        let me = this;

        var url = "/cambiar-estado-producto?producto_id=" + producto_id

        axios 
          .put(url)
          .then(response => {
            var data = response.data;
            if (data == 1){ 
              Swal.fire(
                '¡Lo sentimos!',
                'Tu plan no te permite activar mas produtos, (Puedes desactivar algunos y activar otros o subir de plan).',
                'warning'
              );
            }else{
              Toast.fire({
                  icon: 'success',
                  title: data
              })
            }
            me.getProductos(false);
          })
          .catch(e => {
            console.log(e);
          })
      }
  },
  
  beforeCreate(){
      if (this.$router.app.auth == 0 ){
        this.$router.push({ name: 'invitado-invitado'})
      }
      this.$router.app.mostrarme = 0
  },
  
  mounted(){
      this.getProductos(false)
  }
};
</script>