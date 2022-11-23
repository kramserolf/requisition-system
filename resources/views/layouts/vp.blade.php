<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SJCBI Requisition System with Inventory</title>

    <link rel="icon" href="{{ url('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    



    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

   
    <style>
        .sub-menu{
            color: 	#C0C0C0;
        }

        @media (max-width: 568px) {
            .h-sm-100 {
                height: 100%;
            }
            .sticky-top {
                height: 8%;
            }
            #household{
                width: 10x;
            }
        }

        @media (min-width: 768px) {
            .sticky-top {
                height: 100vh;
        }
        }

    </style>
</head>

<body>
<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="col-12 col-sm-3 col-xl-2 col-sm-1 px-sm-2 px-0 bg-success d-flex sticky-top sticky">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                <div class="mx-auto">
                    <img class="mx-auto d-block d-none d-sm-inline text-center" src="{{ asset('images/sjcbi.png') }}" alt="" width="60" height="60">
                </div>
                <a href="#" class="d-flex align-items-center pb-4 mb-md-0 me-md-auto text-white text-decoration-none text-center">
                    <span class="fs-5 d-none d-sm-inline">SJCBI Requisition System <span style="font-size: 12px;">with</span> Inventory</span>
                </a>
                    <ul class="nav nav-pills fs-5 flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto justify-content-center align-items-center align-items-sm-start px-2 fs-5" id="menu">
                        <li class="nav-item">
                            <a href="{{ route('vp.home') }}" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-house-fill sidebar-home"></i> <span class="ms-1 d-none d-sm-inline sidebar-home">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory') }}" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-basket-fill sidebar-items"></i> <span class="ms-1 d-none d-sm-inline sidebar-items">Inventory</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('vp.requisition') }}" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-file-earmark-text-fill sidebar-requisition"></i> <span class="ms-1 d-none d-sm-inline sidebar-requisition">Requisitions</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-journal-text admin-report"></i> <span class="ms-1 d-none d-sm-inline admin-report">Reports</span>
                            </a>
                        </li>

                    </ul>
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/sjcbi.png') }}" alt="hugenerd" width="28" height="28" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">
                            @auth
                                {{Auth::user()->name}}
                            @endauth
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                Sign out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- logout modal --}}
        <div class="modal fade text-black" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Logout') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Select "Logout" below if you want to end your current session.
                    </div>
                    <div class="modal-footer">

                        <a class="btn btn-outline-danger btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end of logut modal --}}
        <div class="col d-flex flex-column h-sm-100">
            <main class="row overflow-auto">
                <div class="col pt-4 h-100">
                    @yield('content')
                </div>
            </main>
            <footer class="row bg-light mt-auto">
                <div class="text-center">
                    <span class="text-muted">
                        &copy; {{ date('Y') }} SJCBI.
                        All Rights Reserved.
                      </span>
                </div>
            </footer>
        </div>
    </div>
</div>
</body>
</html>
