<template>
<div class="container my-3">
    <div class="card">
        <div class="card-header text-center">
            <h2>RECUPERAR CONTRASEÑA</h2>
            <h5>Ingresa tu correo y te mandaremos la contraseña</h5>
        </div>
        <div class="card-body">
            <form @submit.prevent="check()">
                <div class="form-group">
                    <small class="font-weight-bold">Apellido y Nombre</small>
                    <input type="text" class="form-control" v-model="msg.usuario" maxlength="100" required>
                    <small class="text-danger font-weight-bold" v-if="errors.usuario">{{errors.usuario}}</small>
                </div>
                <div class="form-group">
                    <small class="font-weight-bold">EMAIL</small>
                    <input type="email" class="form-control" v-model="msg.contacto" maxlength="30" id="valContacto" :class="valContacto" required>
                    <small class="text-danger font-weight-bold" v-if="errors.contacto">{{errors.contacto}}</small>
                </div>
                <hr>
                <a href="/" class="btn btn-block btn-danger"><b>Cancelar</b></a>
                <button type="submit" class="btn btn-block btn-success">Enviar</button>
            </form>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return{
            msg:{
                usuario: '',
                contacto: '',
                comentario: 'RECUPERAR PASSWORD',
                entidad_id: 1
            },       
            errors: { usuario: "", contacto: "" }            
        }
    },

    methods: {
        check(){
         this.validarEmail();
        },
        sendMensaje(){
            let me = this;

            var url = '/crear-mensaje';

            axios.post(url,me.msg)
                .then(response => {
                    Swal.fire({
                    title: 'Solicitud Recibida',
                    text: 'Le envieremos su nueva contraseña al email asociado a la cuenta de tuciudad.online.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok, entendido!'
                    }).then((result) => {
                    if (result.value) {
                        window.location.href = '/'
                    }
                    })
                })
                .catch(e => {
                    if (e.response.status == 422) {
                      if(e.response.data.errors.usuario) this.errors["usuario"] = e.response.data.errors.usuario[0];
                      if(e.response.data.errors.contacto) this.errors["contacto"] = e.response.data.errors.contacto[0];
                    }
                })
        },
        validEmail: function(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
            },

        validarEmail() {
            this.errors.contacto = "";
            if (!this.validEmail(this.msg.contacto)) {
                this.errors.contacto = "El formato de email es incorrecto";
            } else {
                var url = "/validar-email-usuario?email=" + this.msg.contacto;
                axios
                .get(url)
                .then(response => {
                    if (response.data == 1) {
                        this.errors.contacto = "El email ingresado no existe en nuestros registros";
                    } else{
                        this.sendMensaje();           
                    }
                })
                .catch(e => {
                    console.log(e);
                });
            }
    },
    },

    computed: {
        valContacto() { 
        return {"is-invalid": this.errors.contacto}; 
        },
  },
}
</script>