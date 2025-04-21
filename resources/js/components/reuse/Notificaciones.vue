<template>
    <div>
        <router-link :to="{ name: 'anunciate-listado' }" class="nav-link" href="#"> 
            <i class="fas fa-bell fa-2x"></i><span v-if="mensajes.length > 0" class="badge badge-danger">{{mensajes.length}}</span>
        </router-link>
    </div>
</template>
<script>
import bus from "../eventBus";

export default {
    data(){
        return {
            mensajes: [],
        }
    },

    methods: {
        getMensajes() {
            let me =this;

            var url = '/listado-mensajes?atendidos=' + 0

            axios.get(url)
                .then(response => {
                    me.mensajes = response.data;
                })
                .catch(e => {
                    console.log(e);
                })
        },

        startInterval() {
            setInterval(() => {
                this.getMensajes();
                bus.$emit('update-anunciate-listado');
            }, 60000);
        }

    },
    
    beforeCreate(){
        if (this.$router.app.auth == 0){
        this.$router.push({ name: 'invitado-invitado'})
        }
    },
    
    mounted() {
        
        this.getMensajes() 
        this.startInterval()
        
        bus.$on('update-bell', data =>{
            this.getMensajes()
        })
        
    }

}
</script>