<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('dist/css/datatables/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/datatables/dataTables.colVis.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/datatables/dataTables.colvis.jqueryui.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/sweetalert2.css')}}">
    <link href="{{asset('dist/css/select2.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/jquery.inputpicker.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    <style>
        .modal {
            overflow-y: auto;
        }
    </style>
</head>
{{--<body class="sidebar-mini layout-fixed sidebar-collapse">--}}
<body class="sidebar-mini layout-fixed sidebar-collapse" style="height: auto;">
<div class="wrapper">


    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <!-- User -->
                <li class="nav-item dropdown user-menu">
                    <div class="btn-group">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            {{Auth::user()->name}}
                        </button>
                        <div class="dropdown-menu">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                                       onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- /User -->
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a class="brand-link">
            <img src="{{asset('imgs/IT.png')}}" alt="IT_NASSARGROUP_Logo" class="brand-image img-circle elevation-4"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Nassar Group</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    {{-- users --}}
                    @if(Auth::user()->role_id == 1)
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link @yield('usersLinkActive')">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>

                        {{-- Sities & Activities --}}
                        <li class="nav-item @yield('places_menu')">
                            <a href="#" class="nav-link @yield('placesLinkActive')">
                                <i class="nav-icon fa fa-globe"></i>
                                <p>
                                    Places
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('sites.index')}}" class="nav-link @yield('sitesLinkActive')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sites</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('activities.index')}}"
                                       class="nav-link @yield('activitiesLinkActive')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Activities</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('sites_activities.index')}}"
                                       class="nav-link @yield('sitesActivitiesLinkActive')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sites Activities</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @endif
                    {{-- Employees data --}}
                    <li class="nav-item @yield('employeesData_menu')">
                        <a href="#" class="nav-link @yield('employeesDataLinkActive')">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                Employees Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        @if(Auth::user()->role_id == 1)
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('employees_departments.index')}}"
                                       class="nav-link @yield('employeesDepartmentsLinkActive')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Departments</p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('employees.index')}}" class="nav-link @yield('employeesLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Employees</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{-- Inventory --}}
                    <li class="nav-item @yield('inventories_menu')">
                        <a href="#" class="nav-link @yield('inventoryLinkActive')">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                Inventories
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('pcs.index')}}" class="nav-link @yield('PCsLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>PCs</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('laptops.index')}}" class="nav-link @yield('laptopsLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laptops</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('screens.index')}}" class="nav-link @yield('screensLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Screens</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('printers.index')}}" class="nav-link @yield('printersLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Printers / Scanners</p>
                                </a>
                            </li>
                        </ul>
{{--                        <ul class="nav nav-treeview">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('barcodes.index')}}" class="nav-link @yield('barcodesLinkActive')">--}}
{{--                                    <i class="far fa-circle nav-icon"></i>--}}
{{--                                    <p>Barcode Scanner</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('access_points.index')}}"
                                   class="nav-link @yield('accessPointLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Access Point</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('modems.index')}}" class="nav-link @yield('modemLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Modems</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('routers.index')}}" class="nav-link @yield('routersLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Routers</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('switches.index')}}" class="nav-link @yield('switchesLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Switches</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('servers.index')}}" class="nav-link @yield('serversLinkActive')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Servers</p>
                                </a>
                            </li>
                        </ul>
                        @if (Auth::user()->role_id == 1)
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('mobiles.index')}}" class="nav-link @yield('mobilesLinkActive')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mobiles Sim</p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid" style="width:fit-conent;">
                <div class="row mb-2">
                    @yield('content_header')
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            @yield('pageContent')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2022-2023 Mohamed Hassan.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 2.2.10
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
<script src="{{asset('dist/js/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dist/js/datatables/jszip.min.js')}}"></script>
<script src="{{asset('dist/js/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('dist/js/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('dist/js/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('dist/js/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('dist/js/datatables/buttons.colVis.min.js')}}"></script>


<script src="{{asset('dist/js/select2.min.js')}}"></script>
<script src="{{asset('dist/js/moment.min.js')}}"></script>
<script src="{{asset('dist/js/jquery.inputpicker.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>

@yield('Js_Page')
</body>
</html>
