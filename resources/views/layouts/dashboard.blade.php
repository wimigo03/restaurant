<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pi-Resto | Home</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}"> 
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">--}}
    <link href="{{ asset('fonts/roboto.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/poppins.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/source.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome_6.0/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles/font-verdana.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2/select2-bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/treeview/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lobibox/lobibox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tooltips/tooltips.min.css') }}" rel="stylesheet">
    {{--<link href="http://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">--}}
    <style>
        .linea-informacion {
            border-bottom: 1px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .btn-float {
            position: fixed;
            top: 0px;
            right: 20px;
            border: none;
            padding: 15px;
            cursor: pointer;
            z-index: 1000;
        }
        .text-bottom {
            position: relative;
        }
        .text-bottom b {
            position: absolute;
            bottom: 0;
        }
    </style>
    @yield('styles')
  </head>
  <body>
    <span class="btn-float">
        <span class="tts:left tts-slideIn tts-custom" aria-label="Salir" style="cursor: pointer;">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="/images/exit.png" alt="Salir" class="imagen-salir">
            </a>
        </span>
    </span>
    @include('layouts.alerta-modal')
    @include('layouts.confirmar-modal')
    <aside class="sidebar">
        <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span>
                    
                </span>
            </a>
        </div>
        <div class="side-inner">
            @include('layouts.partials.perfil') 
            {{--@include('layouts.partials.subperfil')--}} 
            @include('layouts.partials.menu') 
        </div>
    </aside>
    <main>
        <div class="site-section">
            <div class="container">
                @yield('content')
            </div>
        </div>  
    </main>
    
    <script src="{{ asset('js/dashboard/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/popper.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/main.js') }}"></script>
    <script src="{{ asset('js/lobibox/lobibox.js') }}"></script>
    <script src="{{ asset('js/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/datepicker/datepicker.es.js') }}"></script>
    {{--<script src="http://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>--}}

    @yield('scripts')
    
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/treeview/jstree.min.js') }}"></script>

  </body>
</html>