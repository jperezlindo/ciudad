<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Guía de uso</h5>
                <p class="card-text">
                    <b>Nuevo producto:</b> En esta sección podrá cargar los productos/servicios que desea. La cantidad a cargar dependerá del plan solicitado con anterioridad. <br> 
                        ** Imagen del producto: Presionando el botón “Browser” podrá seleccionar una imagen del producto y/o servicio. <br><b> (Para una mejor experiencia de visualización, se recomienda subir fotos en posición vertical)</b> <br>
                        ** Código: Podrá ser cualquier valor único que representará su producto o servicio. <br>
                        ** Nombre: Introducirá el nombre que identifique al mismo. <br>
                        ** Marca/rubro: Completar con la marca que corresponda o categorizar según el rubro. <br>
                        ** Precio: Dependerá del vendedor completar o no (campo no obligatorio). <br>
                        ** Descripción: Campo opcional para agregar cualquier información detallada del producto y/o servicio. <br>
                        - Los productos recién creados, automáticamente se encuentran en estado activo y publicados.
                <p> 
                <p class="card-text">  
                    <b>Mis Productos:</b> Se listan con detalles todos los productos/servicios cargados, con posibilidades de administrar diferentes funciones. <br>
                    ** Buscador: Te permitira encontrar encontrar rápidamente un producto/servicio específico. <br>
                    ** Listar: Listará todos tus productos/servicios que estan actualmente en el sistema.<br> 
                    ** Editar: Podrás modificar cualquier dato del producto/servicio cargado. <br>
                    ** Switch: Le permitira activar o desactivar un producto/servicio. (Al estar desactivado, el producto/servicio ya no estará publicado).
                </p>
                <p class="card-text">
                    <b>Usuarios:</b> Se listan los usuarios que actualmente dados de alta. <br>
                    ** Nuevo Usuario: Podrás dar de alta los usuarios que podrán gestionar el sitio. <br>
                    ** Activar/Desactivar: Te permite cambiar el estado de los usuarios actualmente disponibles. 
                </p>  
                <p class="card-text">
                    <b>Redes Sociales:</b> En esta sección podrás cargar los enlaces a tus redes sociales para facilitar la visita a los mismos.
                </p>
                
            </div>
        </div>
    </div>
</template>
<script>
export default {
    
    beforeCreate(){
        if (this.$router.app.auth == 0){
            this.$router.push({ name: 'invitado-invitado'})
        }
    }

}
</script>