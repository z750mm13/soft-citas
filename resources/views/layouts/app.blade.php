<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('postjs')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('resources/styles/main.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/awesomefont/css/all.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark navbar-expand-md navbar-fixed-top">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#subNavBarDropdown" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="https://www.gob.mx/" aria-label="Para hacer este sitio web accesible al lector de pantalla, Oprima alt + 1. Para dejar de recibir este mensaje, oprima alt + 2"><img src="https://framework-gb.cdn.gob.mx/landing/img/logoheader.svg" width="128" height="48" alt="Página de inicio, Gobierno de México"></a>
            
                <div class="collapse navbar-collapse" id="subNavBarDropdown">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('consultations.index') }}">{{ __('Consultas') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointments.index') }}">{{ __('Citas') }}</a>
                        </li>
                        @if(Auth::user()->rol != 'Encargado de la unidad')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patients.index') }}">{{ __('Pacientes') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('medicines.index') }}">{{ __('Medicamentos') }}</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        <main>
            @yield('content')
        </main>

        <footer class="main-footer">
            <div class="list-info">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3"><img data-v-9e928f9a="" src="https://framework-gb.cdn.gob.mx/landing/img/logoheader.svg" href="/" alt="logo gobierno de méxico" class="logo_footer" style="max-width: 90%;"></div>
                        <div class="col-sm-3" style="padding-left: 0px;">
                            <h5>Enlaces</h5>
                            <ul>
                                <li>
                                    <a href="https://participa.gob.mx" target="_blank" rel="noopener" title="Enlace abre en ventana nueva">Participa</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/publicaciones" target="_blank" rel="noopener" title="Enlace abre en ventana nueva">Publicaciones Oficiales</a>
                                </li>
                                <li>
                                    <a href="http://www.ordenjuridico.gob.mx" target="_blank" rel="noopener" title="Enlace abre en ventana nueva">Marco Jurídico</a>
                                </li>
                                <li>
                                    <a href="https://consultapublicamx.inai.org.mx/vut-web/" target="_blank" rel="noopener" title="Enlace abre en ventana nueva">Plataforma Nacional de Transparencia</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-3">
                            <h5>¿Qué es gob.mx?</h5>
                            <p>Es el portal único de trámites, información y participación ciudadana. <a href="https://www.gob.mx/que-es-gobmx">Leer más</a></p>
                            <ul>
                                <li>
                                    <a href="https://datos.gob.mx">Portal de datos abiertos</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/accesibilidad">Declaración de accesibilidad</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/privacidadintegral">Aviso de privacidad integral</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/privacidadsimplificado">Aviso de privacidad simplificado</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/terminos">Términos y Condiciones</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/terminos#medidas-seguridad-informacion">Política de seguridad</a>
                                </li>
                                <li>
                                    <a href="https://www.gob.mx/sitemap">Mapa de sitio</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-3" style="padding-left: 0px;">
                            <h5>
                                <a href="https://www.gob.mx/tramites/ficha/presentacion-de-quejas-y-denuncias-en-la-sfp/SFP54">Denuncia contra servidores públicos</a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid footer-pleca">
                <div class="row">
                    <div class="col">
                        <br><br>
                    </div>
                </div>
            </div>
        </footer>
        @include('messages.success')
    </div>
    @stack('js')
</body>
</html>
