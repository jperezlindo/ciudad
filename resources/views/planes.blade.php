<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body background="imagenes/fondo2.jpg" style="background-attachment: fixed;">
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h4>Planes disponibles en <b>tuciudad.online</b></h4>
                                <p class="font-weight-light">Todos nuestos planes son a pagos mensuales, no tenemos suscripción. El cliente prodrá rescindir el servicio, dejando de abonar la cuota mensual.</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="{{route('index')}}">Volver</a>
                            </div>   
                        </div>
                    </div>
                    <div class="card-body">
                    
                        <div class="card mb-3">
                            <div class="card-body">
                                Nos manejamos con tarjetas publicitarias. ¿Qué son las tarjetas publicitarias? Son las publicaciones que pueden realizar los clientes y están compuestas de una imagen y sus datos relacionados.
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>PLAN PUBLICITARIO</h3>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h4><span class="badge badge-pill badge-success">¡GRATIS!</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Publicá tu Entidad (comercio, servicio o institución) </h5>
                                <h6 class="card-text"><p>Este plan solo brindará datos de contacto y dirección de la entidad.</p></h6>
                                <p class="card-text">* Adquirí el plan el mes de mayo y usalo <b>gratis</b> hasta el 1ro de Agosto del 2020. Luego a solo <span class="badge badge-pill badge-success">$ 150.00</span> mensuales</p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>PLAN INICIAL</h3>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h4><span class="badge badge-pill badge-success">¡GRATIS!</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Publicá tu entidad + 4 tarjetas</h5>
                                <h6 class="card-text"><p>Con posibilidad de agregar 4 publicaciones internas al mismo.</p></h6>
                                <p class="card-text">* Adquirí el plan el mes de mayo y usalo <b>gratis</b> hasta el 1ro de Agosto del 2020. Luego a solo <span class="badge badge-pill badge-success">$ 250.00</span> mensuales</p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>PLAN BASICO</h3>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h4><span class="badge badge-pill badge-success">$ 400.00/mes</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Publicá tu entidad + 20 tarjetas</h5>
                                <h6 class="card-text"><p>Orientado a aquellos que buscan una relación servicio/precio equilibrada para publicar su comercio y lo que ofrece.</p></h6>
                            </div>
                        </div>


                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>PLAN ESTANDAR</h3>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h4><span class="badge badge-pill badge-success">$ 550.00/mes</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Publicá tu entidad + 40 tarjetas</h5>
                                <h6 class="card-text"><p>Orientado a aquellos que buscan aumentar sus ventas publicando más productos a un precio accesible.</p></h6>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>PLAN PERSONALIZADO</h3>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Publicá tu entidad + las tarjetas que quieras</h5>
                                <h6 class="card-text"><p>Orientado a aquellos que requieran publicar más de 40 productos. Adicionando al valor del plan estándar la suma de $ 10,00 por producto agregado.</p></h6>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h3>PLAN PREMIUM</h3>
                                    </div>
                                    <div class="col-md-3 mt-2 text-center">
                                        <h6><span class="badge badge-pill badge-danger">Valor real <s>$ 1100.00/mes</s> </span></h6>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h4><span class="badge badge-pill badge-success">50% off $ 550.00/mes</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Publicá tu entidad + 100 tarjetas</h5>
                                <h6 class="card-text"><p>Oferta de lanzamiento. Contratando el plan PREMIUM el mes de mayo, pagás mensualmente el 50% del valor real, durante todo el 2020.</p></h6>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white text-center text-black-50 py-3 mt-2 sticky-bottom shadow">
            Go-Developers | Copyright @ {{ date('Y')}} | Versión Beta | <a href="{{ route('terminos') }}">Términos y condiciones de uso - Privacidad</a>
    </footer>

        
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>