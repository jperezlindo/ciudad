require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import router from './routes'
//import Axios from 'axios';


//Vue.component('usuarios-listado', require('./components/usuarios/Listado.vue').default);
Vue.component('usuarios-formulario', require('./components/usuarios/Formulario.vue').default);

//Vue.component('entidades-listado', require('./components/entidades/Listado.vue').default);
Vue.component('entidades-formulario', require('./components/entidades/Formulario.vue').default);

//Vue.component('crear-entidad-usuario', require('./components/entidadUsuario/CrearEntidadUsuario.vue').default);
//Vue.component('editar-entidad-usuario', require('./components/entidadUsuario/EditarEntidadUsuario.vue').default);

//Vue.component('productos-listado', require('./components/productos/Listado.vue').default);
//Vue.component('productos-formulario', require('./components/productos/Formulario.vue').default);

Vue.component('administrador', require('./components/administrador/Administrador.vue').default);

Vue.component('invitado', require('./components/invitado/Invitado.vue').default);
Vue.component('localidades', require('./components/invitado/Localidades.vue').default);
//Vue.component('entidades', require('./components/invitado/Entidades.vue').default);
Vue.component('entidad-data', require('./components/invitado/EntidadData.vue').default);
//Vue.component('productos', require('./components/invitado/Productos.vue').default);

//Vue.component('anunciate-formulario', require('./components/anunciate/Formulario.vue').default);
Vue.component('anunciate-listado', require('./components/anunciate/Listado.vue').default);


Vue.component('botones-crear-cancelar', require('./components/reuse/BotonesCrearCancelar.vue').default);
Vue.component('left-navbar', require('./components/reuse/LeftNavbar.vue').default);
Vue.component('loading', require('./components/reuse/Loading.vue').default);
Vue.component('notificaciones', require('./components/reuse/Notificaciones.vue').default);

Vue.component('redes-formulario', require('./components/redes/Formulario.vue').default);
Vue.component('entidad-red-formulario', require('./components/redes/FormularioEntidadRed.vue').default);

Vue.component('recuperar-password', require('./components/invitado/RecuperarPassword.vue').default);

//import auth from './mixins/auth';
//Vue.mixin(auth);
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;
/* Para agregar el toast
    Toast.fire({
        icon: 'success',
        title: 'Gracias por elegirnos, nos pondremos en contacto para confirmar el pedido.'
    })

*/

const swalConfirm = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});
window.swalConfirm = swalConfirm;

//OCULTAR MENU EN TELEFONOS AL HACER CLICK EN OTRO LADO
$(function() {
    $(document).click(function (event) {
        $('.navbar-collapse').collapse('hide');
    });
});

const app = new Vue({
    el: '#app',
    data: {
        mostrarme: 1,
        id_localidad: 0,
        auth: 1
    },

    methods: {
        getAuth(){
            let me = this;
            var url = '/get-auth-user';

            axios.get(url)
                .then(response => {
                    me.auth = response.data;
                })
                .catch(e => {
                    console.log(e)
                })
        },
    },
    
    router,

    mounted(){
        this.getAuth()
    }
});

//Quitar advertencia del console -> "You are running Vue in development mode"
Vue.config.productionTip = false;

//Quitar advertencia del console -> "Failed to parse SourceMap"
//Inspeccionar >> settings (f1) >> deshabilites las opciones -> Enable JavaScript source maps/Enable CSS source maps


