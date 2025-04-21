<template>
<div class="container my-3">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-block btn-primary" type="button" disabled>
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                Cargando {{nombre}}...
            </button>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: ['nombre']
}
</script>
