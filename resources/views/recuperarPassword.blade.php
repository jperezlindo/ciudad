<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Recuperar contraseña</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body class="" background="imagenes/fondo2.png" style="background-attachment: fixed;">
        <div id="app" class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                <br><br><br>
                    <div class="card">
                        <div class="card-body">
                            <recuperar-password/>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white text-center text-black-50 py-3 mt-2 sticky-bottom shadow">
            Go-Developers | Copyright @ {{ date('Y')}} | Versión Beta | <a href="{{ route('terminos') }}">Términos y condiciones de uso - Privacidad</a>
        </footer>
        <script src="{{ asset ('js/app.js')}}"></script>
    </body>
</html>