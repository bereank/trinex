<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>SAP Approval Express Way</title>

    <link rel="stylesheet" href="/css/app.css">
    <link rel="shortcut icon" href="{{asset('/img/users.png')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>


            <ul class="navbar-nav ml-auto">
            <div>

               <h3><b>{{Auth::user()->name }}</b></h3> 
            </div>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/home" class="brand-link">
                <img src="{{asset('/img/users.png')}}" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Express Way</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/v1/dashboard')}}">
                                <i class="nav-icon fas fa-tachometer-alt orange"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>



                        @foreach (Auth::user()->databases as $item)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-check indigo"></i>

                       
                                <p>
                                    {{$item->dbdetails->db_name}}
                                    <i class="right fa fa-angle-left"></i>


                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                           
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('expense',['client_id' => $item->dbdetails->client_id])}}">
                                        <i class="nav-icon fas fa-file-contract purple"></i>
                                        <p>
                                         Purchase Requests
                                            <span class="badge badge-info right">{{$item->dataPendingRequests}}</span>
                                        </p>
                                    </a>
                                </li>

                                   
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('approvalrequest.index',['client_id' => $item->dbdetails->client_id])}}">
                                        <i class="nav-icon fas fa-solid fa-book purple"></i>
                                        <p>
                                            Approvals
                                            <span class="badge badge-info right">{{$item->dataPendingRequests}}</span>
                                        </p>
                                    </a>
                                </li>
                             
                     
                            </ul>
                         
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-check indigo"></i>

                       
                                <p>
                                    Reports
                                    <i class="right fa fa-angle-left"></i>


                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                           
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('expense.report',['client_id' => $item->dbdetails->client_id])}}">
                                        <i class="nav-icon fas fa-file-contract purple"></i>
                                        <p>
                                         Purchase Requests Reports
                                            <span class="badge badge-info right">{{$item->dataPendingRequests}}</span>
                                        </p>
                                    </a>
                                </li>

                                
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('approvalrequest.reports',['client_id' => $item->dbdetails->client_id])}}">
                                        <i class="nav-icon fas fa-file-contract purple"></i>
                                        <p>
                                         Approval Reports
                                            <span class="badge badge-info right">{{$item->dataPendingRequests}}</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                         
                        </li>


                        @endforeach               


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('settings')}}">
                                <i class="nav-icon fas fa-cogs green"></i>
                                <p>
                                    Set SAP Password
                                </p>
                            </a>
                        </li>
         
                      

                        @if(Auth::user()->UserType == 2)

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-solid fa-book purple"></i>
                                <p>
                                Approval Process
                                    <i class="right fa fa-angle-left"></i>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('stages.index')}}">
                                        <i class="nav-icon fas fa-solid fa-book purple"></i>
                                        <p>
                                        Approval Stages
                                        </p>
                                    </a>
                                </li>
        
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('templates.index')}}">
                                        <i class="nav-icon fas fa-solid fa-book purple"></i>
                           
                                        <p>
                                           Templates
                                        </p>
                                    </a>
                                </li>
                          
                            </ul>

                        </li>

                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/v1/system-users')}}">
                                <i class="nav-icon fas fa-solid fa-book purple"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                   

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                <i class="nav-icon fa fa-power-off red"></i>
                                <p>
                                    {{ __('Logout') }}
                                </p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('main-content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">

            <!-- Default to the left -->
            <strong>Copyright &copy; 2023 <a href="https://cargen.com" target="_target">SAP Approval Express Way</a>.
                it@cargen.com</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <script src="/js/app.js"></script>
    @livewireScripts
</body>

<script>
    window.addEventListener('alert', event => {
                 toastr[event.detail.type](event.detail.message,
                 event.detail.title ?? ''), toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                    }
                });
</script>


</html>