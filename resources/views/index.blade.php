<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>tuciudad.online</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=3') }}" rel="stylesheet">
</head>
<body background="imagenes/fondo2.jpg" style="background-attachment: fixed;">
    <div id="app" class="d-flex flex-column h-screen justify-content-between">
        <header>
            <!-- Menu de navegacion -->
            <div>
                <nav class="navbar navbar-dark navbar-expand-md shadow fixed-top mb-3" style="background:#ff6600;">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <h2><b><i class="fab fa-tumblr"></i>uciudad</b></h2>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="fas fa-bars fa-2x"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            @guest
                            <ul class="navbar-nav mr-auto">
                                <left-navbar v-if="id_localidad" :localidad="id_localidad"/>
                            </ul>
                            @endguest
                            @Auth
                            <ul class="navbar-nav mr-auto">
                                @if (Auth::user()->rol_id == 2)
                                <li class="nav-item dropdown mt-1">
                                <h5>
                                    <router-link :to="{ name: 'crear-productos', params: {idEntidad: {{ Auth::user()->entidad_id }} }}" class="nav-link">
                                        Nuevo Producto
                                    </router-link>
                                </5>
                                </li>
                                <li class="nav-item dropdown mt-1">
                                <h5>
                                    <router-link :to="{ name: 'listado-productos'}" class="nav-link">
                                       Mis Productos
                                    </router-link>
                                </5>
                                </li>
                                <!--
                                <li class="nav-item dropdown mt-1">
                                <h5>
                                    <router-link :to="{ name: 'administrador-usuarios-listado', params: {idEmpresa: {{ Auth::user()->entidad_id }} }}" class="nav-link">
                                       Usuarios
                                    </router-link>
                                </5>
                                </li>
                                -->
                                <li class="nav-item dropdown mt-1">
                                <h5>
                                    <router-link :to="{ name: 'listado-entidad-redes'}" class="nav-link">
                                       Redes Sociales
                                    </router-link>
                                </5>
                                </li>
                                <li class="nav-item dropdown mt-1">
                                <h5>
                                    <router-link :to="{ name: 'editar-empresa', params: {idEmpresa : {{ Auth::user()->entidad_id }} }}" class="nav-link">
                                        Mi Empresa
                                    </router-link>
                                </5>
                                </li>
                                @endif
                                @if (Auth::user()->rol_id == 1)
                                <li class="nav-item dropdown">
                                    <router-link class="nav-link" :to="{ name: 'crear-entidad-usuario'}" >
                                        <i class="fas fa-calendar-plus fa-2x"></i>
                                    </router-link>
                                </li>                        
                                <li class="nav-item dropdown">
                                    <router-link :to="{ name: 'listado-usuarios'}" class="nav-link ">
                                        <i class="fas fa-users fa-2x"></i>
                                    </router-link>
                                </li>
                                <li class="nav-item dropdown">
                                    <router-link :to="{ name: 'listado-entidades'}" class="nav-link">
                                        <i class="fas fa-city fa-2x"></i>
                                    </router-link>
                                </li>
                                <li class="nav-item dropdown">
                                    <router-link :to="{ name: 'listado-pagos'}" class="nav-link">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                    </router-link>
                                </li>
                                <li class="nav-item dropdown">
                                    <router-link :to="{ name: 'listado-redes'}" class="nav-link">
                                    <i class="fas fa-project-diagram fa-2x"></i>
                                    </router-link>
                                </li>
                                <li class="nav-item dropdown">
                                    <router-link :to="{ name: 'listado-categorias-entidad'}" class="nav-link">
                                    <i class="fas fa-align-left fa-2x"></i>
                                    </router-link>
                                </li>  
                                @endif  
                            </ul>
                            @endAuth   
                            <!-- Right Side Of Navbar -->
                            
                            <ul class="navbar-nav ml-auto">
                            @guest
                                <li class="nav-item">
                                    <router-link :to="{ name: 'anunciate-formulario', params: {idEntidad: 1}}"  class="nav-link badge badge-danger mt-1" href="#">
                                        <h4>¡PUBLICÁ!</h4>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('planes') }}">
                                       COSTOS
                                    </a>
                                </li>
                                <!-- Authentication Links -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                       ACCESO CLIENTES
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <!-- Notificaiones -->
                                    <notificaciones />
                                </li>
                                <li class="nav-item dropdown mt-2">
                                <h5>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->nombre }} <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                        <router-link type="button" class="dropdown-item" 
                                        :to="{ name: 'administrador-usuarios-formulario', params: {idUsuario : {{ Auth::user()->id }}, idEmpresa: {{ Auth::user()->entidad_id }} }}">
                                            Mi perfil
                                        </router-link>
                                        
                                        <router-link :to="{ name: 'cambiar-password', params: {idUser: {{ Auth::user()->id }} }}" class="dropdown-item">
                                            Cambiar contraseña
                                        </router-link>
                                        <hr>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            SALIR
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </h5>
                                </li>
                            @endguest
                            </ul>
                        </div>
                    </div>
                </nav>
                <br><br><br>
            </div>
        </header>
        <main>         
            <!-- Se cargan los componentes -->
            
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <router-view :auth="auth" class="mt-3"></router-view>
                    @Auth
                        <administrador class="mt-3" v-if="mostrarme"/>
                    @else
                        <invitado v-if="mostrarme"/>
                    @endAuth  
                </div>
            </div>
            
            @yield('content')


        <main>

        <footer class="bg-white text-center text-black-50 py-3 mt-2 sticky-bottom shadow">
            Go-Developers | Copyright @ {{ date('Y')}} | Versión Beta | <a href="{{ route('terminos') }}">Términos y condiciones de uso - Privacidad</a>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js?v=3') }}" defer></script>
</body>
</html>