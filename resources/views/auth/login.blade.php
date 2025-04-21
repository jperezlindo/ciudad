<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inicio de Sesion</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Fonts <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->
        

    </head>
    <body class="" background="imagenes/fondo2.jpg" style="background-attachment: fixed;">
        <div id="mt-login" class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Inicia Sesión en tuciudad.online</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-3">
                                        <label>Correo Electrónico</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-3">
                                        <label>Contraseña</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                <!--
                                    <div class="col-md-3 offset-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                Recordarme
                                            </label>
                                        </div>
                                    </div>
                                -->
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <button type="submit" class="btn btn-outline-success btn-block">
                                                <b>ENTRAR</b>
                                            </button>
                                        </div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3 mt-2">
                                            <a href="/" class="btn btn-outline-danger btn-block"><b>CANCELAR</b></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 offset-md-6">
                                        <a class="btn btn-link" href="{{ url('/recuperar-password') }}">
                                            {{ __('Recuperar Contraseña') }}
                                        </a>
                                        </div>
                                    </div>                                 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset ('js/app.js')}}"></script>
    </body>
</html>