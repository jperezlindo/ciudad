<template>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h2>Cambiar Contraseña</h2>
                </div>
                <div class="card-body">
                    <!-- Aca empieza el formulario-->
                    <form class="form-group" @submit.prevent="updatePassword()"> 
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Ingrese su contraseña Actual</label>
                                <input v-model="user.myPassword" type="password" class="form-control" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Ingrese su nueva Contraseña</label>
                                <input v-model="user.password" type="password" class="form-control" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Confirme su nueva contraseña</label>
                                <input @change="confirmar()" v-model="user.password_confirmation" type="password" class="form-control" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button @click="irAAdministrador()" type="button" class="btn btn-danger mb-2 btn-block">CANCELAR</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success mb-2 btn-block">CAMBIAR</button>
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
        return {
            
            user: {
                usuario_id: null,
                myPassword: '',
                password: '',
                password_confirmation: ''
            }


        }
    },

    methods: {
        confirmar(){
            let me = this;

            if (me.user.password != me.user.password_confirmation){
                me.user.password = '';
                me.user.password_confirmation = '';
                Swal.fire('Las contraseñas nuevas no coinciden');
                return;
            }
        },

        updatePassword(){
            let me =this;
            var url = '/update-password';
            
            swalConfirm.fire({
                title: '¿Está seguro que desea cambiar la password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'SI',
                cancelButtonText: 'NO',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    axios.put(url, me.user)
                    .then(response => {
                        if (response.data){
                            Toast.fire({
                                icon: 'success',
                                title: 'El cambio se realizó con éxito.'
                            })
                            me.irAAdministrador()                        
                        }else{
                            Swal.fire('La contraseña actual no coincide con nuestros registros.');
                        }
                        
                    })
                    .catch(e => {
                        if (e.response.status == 422) {
                            var errors = e.response.data.errors;

                            if (errors.myPassword){
                                Swal.fire(errors.myPassword[0]);
                            }

                            if (errors.password){
                                Swal.fire(errors.password[0]);
                            }
                            
                        }
                    })
                } 
            }) 
            
        },

        irAAdministrador(){
            let me = this;

            me.$router.push({ name: 'administrador-administrador' });
        }
    },
    /*
    beforeCreate(){
        if (this.$router.app.auth == 0 ){
            this.$router.push({ name: 'invitado-invitado'})
        }
    },
    */
    created(){
        this.user.usuario_id = this.$route.params.idUser
        this.$router.app.mostrarme = 0 
    }
}
</script>