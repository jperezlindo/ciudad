<template>
<div class="container my-3">
    <div class="card">
        <div class="card-header">
            <h2>Nuevo pago</h2>
        </div>
        <div class="card-body">
            <form @submit.prevent="storePago()">
                <div class="row">
                    <div class="col text-center">
                        <h3>{{entidad}}</h3>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label>Monto a pagar</label>
                        <input type="number" class="form-control" v-model="pago.precio" required>
                    </div>
                    <div class="col">
                        <label>Comentario</label>
                        <input type="text" class="form-control" v-model="pago.comentario">
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-block  btn-success">Confirmar Pago</button>
            </form>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return{
            entidad: null,
            pago: {
                entidad_id: null,
                precio: '',
                comentario: ''
            }
        }
    },

    methods: {
        storePago(){
            let me = this;

            var url = '/pago';
        
            axios.post(url,me.pago)
                .then(response => {
                    alert(response.data);
                    me.$router.push({ name: "listado-pagos" });
                })
                .catch(e => {
                    console.log(e);
                })
        }
    },

    beforeCreate(){
        if (this.$router.app.auth != 1){
            this.$router.push({ name: 'invitado-invitado'})
        }
    },

    created(){
        this.pago.entidad_id = this.$route.params.idEntidad
        this.entidad = this.$route.params.entidad
        this.$router.app.mostrarme = 0
    }
}
</script>