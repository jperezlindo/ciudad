<template>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>¡Envíanos los siguientes datos y nos contactaremos con Usted!</h2>
                </div>
                <div class="card-body">
                    <form @submit.prevent="sendMensaje()">
                            <div class="form-group" v-if="msg.entidad_id == 1">
                                <small class="font-weight-bold">DNI</small>
                                <input type="text" class="form-control" @keypress="soloNumeros()" v-model="comentarioConcat.dni" placeholder="Ingresar el nro de DNI sin puntos." maxlength="30" required>
                            </div>
                            <div class="form-group">
                                <small class="font-weight-bold">Apellido y Nombre</small>
                                <input type="text" class="form-control" v-model="msg.usuario" maxlength="30" required>
                                <small class="text-danger font-weight-bold" v-if="errors.usuario">{{errors.usuario}}</small>
                            </div>
                            <div class="form-group">
                                <small class="font-weight-bold">WhatsApp</small>
                                <input type="text" class="form-control" @keypress="soloNumeros()" v-model="msg.contacto" maxlength="10" placeholder="Ingregar nro sin ( () , 0 , - , 15 , . )" required>
                                <small class="text-danger font-weight-bold" v-if="errors.contacto">{{errors.contacto}}</small>
                            </div>
                            <div class="form-group" v-if="msg.entidad_id == 1">
                                <small class="font-weight-bold">Email</small>
                                <input type="email" class="form-control" v-model="comentarioConcat.email" maxlength="100">
                            </div>
                            <div class="form-group" v-if="msg.entidad_id == 1">
                                <small class="font-weight-bold">Nombre (empresa/servicio)</small>
                                <input type="text" class="form-control" v-model="comentarioConcat.nombre_empresa" maxlength="30" required>
                            </div>
                            <div class="form-group" v-if="msg.entidad_id == 1">
                                <small class="font-weight-bold">CUIT/CUIL</small>
                                <input type="text" class="form-control" @keypress="soloNumeros()" placeholder="Ingregar nro sin ( - , . )"  v-model="comentarioConcat.cuit" maxlength="11" required>
                            </div>
                            <div class="form-group" v-if="msg.entidad_id == 1">
                                <small class="font-weight-bold">Rubro</small>
                                <input type="text" class="form-control" v-model="comentarioConcat.rubro" maxlength="30" required>
                            </div>
                            <div class="form-group">
                                <small class="font-weight-bold">Localidad</small>
                                <input type="text" class="form-control" v-model="msg.localidad" maxlength="100">
                            </div>
                            <div class="form-group" v-if="msg.entidad_id != 1">
                                <small class="font-weight-bold">Comentario</small>
                                <textarea class="form-control" rows="5" v-model="msg.comentario" required></textarea>
                            </div> 
                        <!--SPINNER-->
                        <div class="row" v-if="imagenCargar">
                            <div class="mx-auto ">
                            <button class="btn btn-primary" type="button" disabled>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                <strong class="text-white">Enviando datos...</strong>
                            </button>
                            </div>
                        </div>
                        <!--FIN SPINNER-->
                        <div class="row" v-else>
                            <div class="col">
                                <button type="button" class="btn btn-block  btn-danger" @click="irAInvitado()">CANCELAR</button>
                            </div>
                            <div class="col">
                                <button id="botonSubmit" class="btn btn-block btn-success">ENVIAR</button>
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
    data(){
        return{
            msg:{
                usuario: '',
                contacto: '',
                localidad: '',
                comentario: '',
                entidad_id: '',
            },
            comentarioConcat: { dni: "", email: "", nombre_empresa: "", cuit: "", rubro: "" },          
            errors: { usuario: "", contacto: "", comentario: "" },
            imagenCargar: 0        
        }
    },

    methods: {
        sendMensaje(){ 
            document.getElementById('botonSubmit').disabled=true;
            
            let me = this;

            if(me.msg.entidad_id == 1){
                me.msg.comentario = 
                    me.comentarioConcat.cuit + " " + 
                    me.comentarioConcat.nombre_empresa +  " " +
                    me.comentarioConcat.rubro +  " " +  
                    me.comentarioConcat.email + " " + 
                    me.comentarioConcat.dni + " " ;
            }
         
            var url = '/crear-mensaje';

            me.imagenCargar = 1;

            axios.post(url,me.msg)
                .then(response => {
                    me.imagenCargar = 0;
                    me.$router.push({name: 'invitado-invitado'});
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.data,
                        showConfirmButton: true,
                        timer: 3000
                    }) 
                })
                .catch(e => {
                    //console.log(e);
                    console.log(e.response.data.errors.contacto[0]);
                    me.imagenCargar = 0;
                    if (e.response.status == 422) {
                      if(e.response.data.errors.usuario) this.errors["usuario"] = e.response.data.errors.usuario[0];
                      if(e.response.data.errors.contacto) this.errors["contacto"] = e.response.data.errors.contacto[0];
                      if(e.response.data.errors.comentario) this.errors["comentario"] = e.response.data.errors.comentario[0];
                    }
                })
        },

        irAInvitado(){
            let me = this
            me.$router.push({ name: "invitado-invitado" })
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

    },

    created(){
        this.$router.app.mostrarme = 0
        this.msg.entidad_id = this.$route.params.idEntidad
    },
}
</script>