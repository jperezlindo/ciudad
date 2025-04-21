<template>
    <div class="container">
        <div class="row">
            <div class="card-group mb-1 col-md-3" v-for="localidad in localidades" :key="localidad.id">
                <router-link class="card shadow" :to="{ name: 'invitado-entidades', params: {idLocalidad: localidad.id, idEntidadCategoria: 0}}">
                    <div class="card-body">
                        <font color=orange>
                            <h3 class="card-title text-center mt-2">{{localidad.nombre}}</h3>
                        </font>
                    </div>
                </router-link>
            </div>
        </div>
    </div>    
</template>
<script>

export default {
    
    props:[ 'localidades']

}
</script>  