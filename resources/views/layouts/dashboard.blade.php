<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Pi-Resto | Home</title>
        <link rel="icon" href="{{ asset('images/favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('fonts/roboto.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('fonts/source.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('dataTable/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dataTable/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome_6.0/css/all.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/dashboard/bootstrap.min.css') }}" rel="stylesheet">
        {{--<link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}" rel="stylesheet">--}}
        <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/styles/font-verdana.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/select2/select2.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap4.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/treeview/style.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/lobibox/lobibox.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/datepicker/datepicker.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/tooltips/tooltips.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('js/datepicker/themes/jquery-ui.css') }}" rel="stylesheet">
        {{--<style>
            .linea-informacion {
                border-bottom: 1px solid #3498db;
                padding-bottom: 5px;
                margin-bottom: 5px;
            }
            .text-bottom {
                position: relative;
            }
            .text-bottom b {
                position: absolute;
                bottom: 0;
            }--}}
        </style>
        @yield('styles')
    </head>
    @include('layouts.alerta-modal')
    @include('layouts.confirmar-modal')
    <body class="sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-widget="pushmenu"><i class="fa fa-bars"></i></a>
                    </li>
                    {{-- Aqui se puede aumentar aparece al lado del ___Menu--}}
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto font-roboto-13">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            {{ strtoupper(Auth::user()->username) }} - {{ ucwords(strtolower(Auth::user()->cargo_header)) }} &nbsp;&nbsp;<i class="fa fa-cog fa-fw mr-2"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('logout') }}" class="dropdown-item font-roboto-13" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out mr-1"></i>Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{--route('dashboard')--}}" class="brand-link">
                    <img src="{{ url(Auth()->user()->cliente->url_img) }}" alt="img" class="brand-image img-circle elevation-4" style="opacity: .8">
                    <span class="brand-text font-weight-light font-roboto-15">{{ Auth()->user()->cliente->nombre }}</span>
                </a>

                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center align-items-center">
                        <div class="info">
                            <a href="#" class="d-block text-uppercase font-roboto-11">
                                <span class="font-roboto-12">
                                    <i class="fa fa-briefcase"></i>&nbsp;{{ auth()->user()->cargo_header }}
                                </span>
                                <select name="menu_dashboard" id="menu_dashboard" class="form-control" onchange="goToDashboardType(this.value);">
                                    <option value="OPERATIVO" @if(Session::get('menu') == 'OPERATIVO') selected @endif>OPERATIVO</option>
                                    @canany(['estado.resultado.index','balance.apertura.index','plan.cuentas.index','plan.cuentas.auxiliar.index','tipo.cambio.index','comprobante.index'])
                                        <option value="CONTABLE" @if(Session::get('menu') == 'CONTABLE') selected @endif>CONTABLE</option>
                                    @endcanany
                                    @canany(['estado.resultado.f.index','balance.apertura.f.index','comprobantef.index'])
                                        <option value="CONTABLEF" @if(Session::get('menu') == 'CONTABLEF') selected @endif>CONTABLEF</option>
                                    @endcanany
                                    @canany(['caja.venta.index','sucursal.index','mesas.index','productos.index'])
                                        <option value="RESTO" @if(Session::get('menu') == 'RESTO') selected @endif>RESTAURANT</option>
                                    @endcanany
                                    @canany(['cargos.index','personal.index'])
                                        <option value="RRHH" @if(Session::get('menu') == 'RRHH') selected @endif>RECURSOS HUMANOS</option>
                                    @endcanany
                                </select>
                            </a>
                        </div>
                    </div>

                    <nav class="mt-2 font-roboto-14">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            @include('layouts.partials.menu')
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            {{--<div class="col-sm-6">
                                <h4 class="m-0 text-dark">
                                    @yield('page_title')
                                </h4>
                            </div>--}}
                            <div class="col-sm-12 font-roboto-13">
                                <ol class="breadcrumb float-sm-right">
                                    @section('breadcrumb')
                                    @show
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        @if(View::hasSection('content'))
                            @yield('content')
                        @else
                            #
                        @endif
                    </div><!-- /.container-fluid -->
                </div>
            </div>
            <!-- /.content-wrapper -->
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <form action="{{route('logout')}}" method="POST" id="form_id">
                        @csrf
                        <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer font-roboto-12">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    cc
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2024 - {{ date('Y') }} <a href="#">--</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>
        {{--<aside class="sidebar">
            <div class="toggle">
                <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                    <span>

                    </span>
                </a>
            </div>
            <div class="side-inner">
                @include('layouts.partials.perfil')
                @include('layouts.partials.menu')
            </div>
        </aside>
        <main>
            <div class="site-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 px-1 pr-1 font-roboto-12 bg-white">
                            @section('breadcrumb')
                            @show
                        </div>
                        <div class="col-md-5 px-1 pl-1 font-roboto-12 bg-white" style="display: flex; justify-content: flex-end; align-items: flex-end;">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <div class="dropdown">
                                <span class="">
                                    <i class="fa-solid fa-user fa-fw"></i>
                                    {{ Auth::user()->username }} - {{ ucwords(strtolower(Auth::user()->cargo_header)) }}
                                    <i class="fa-solid fa-caret-down fa-fw"></i>
                                </span>
                                <div class="dropdown-content right">
                                    <a href="#">
                                        <i class="fa-solid fa-id-badge fa-fw"></i> Mi Perfil
                                    </a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket fa-fw"></i> Salir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            @include('layouts.partials.header')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </main>--}}

        <script src="{{ asset('dataTable/js/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('dataTable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dataTable/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('dataTable/js/datatable-language.js') }}"></script>
        {{--<script src="{{ asset('js/dashboard/jquery-3.3.1.min.js') }}"></script>--}}
        {{--<script src="{{ asset('js/dashboard/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/dashboard/popper.min.js') }}"></script>
        <script src="{{ asset('js/dashboard/main.js') }}"></script>--}}
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('js/lobibox/lobibox.js') }}"></script>
        {{--<script src="{{ asset('js/datepicker/datepicker.min.js') }}"></script>
        <script src="{{ asset('js/datepicker/datepicker.es.js') }}"></script>---}}
        <script src="{{ asset('js/datepicker/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/datepicker/datepicker-es.js') }}"></script>
        <script src="{{ asset('js/cleave/cleave.min.js') }}"></script>
        <script src="{{ asset('js/cleave/addons/cleave-phone.us.js') }}"></script>

        @yield('scripts')

        <script src="{{ asset('js/select2/select2.min.js') }}"></script>
        <script src="{{ asset('js/treeview/jstree.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#menu_dashboard').select2({
                    theme: "bootstrap4",
                    placeholder: "--Seleccionar--",
                    width: '100%'
                });
            });
            function goToDashboardType(selectedValue) {
                fetch('/update-dashboard', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ menu: selectedValue })
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('dashboard-content').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
            }
        </script>
    </body>
</html>
