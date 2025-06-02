<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png"') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>

                        {{-- Semua role bisa lihat Dashboard --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                                <span><i class="ti ti-layout-dashboard"></i></span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        {{-- Hanya role 1 dan 2 --}}
                        @if (in_array(Auth::user()->role_id, [1, 2]))
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Menu</span>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('jabatan.list') }}" aria-expanded="false">
                                    <span><i class="ti ti-article"></i></span>
                                    <span class="hide-menu">Jabatan</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('bpjsKesehatan') }}" aria-expanded="false">
                                    <span><i class="ti ti-file"></i></span>
                                    <span class="hide-menu">BPJS Kesehatan</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('bpjs-ketenaga-kerjaan') }}"
                                    aria-expanded="false">
                                    <span><i class="ti ti-cards"></i></span>
                                    <span class="hide-menu">BPJS Ketenaga Kerjaan</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('karyawan') }}" aria-expanded="false">
                                    <span><i class="ti ti-file-description"></i></span>
                                    <span class="hide-menu">Karyawan</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('cuti') }}" aria-expanded="false">
                                    <span><i class="ti ti-typography"></i></span>
                                    <span class="hide-menu">Cuti</span>
                                </a>
                            </li>
                        @endif
                        @if (in_array(Auth::user()->role_id, [3]))
                            {{-- Semua role boleh ajukan cuti --}}
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('ajukan.cuti') }}" aria-expanded="false">
                                    <span><i class="ti ti-typography"></i></span>
                                    <span class="hide-menu">Ajukan Cuti</span>
                                </a>
                            </li>
                        @endif
                        {{-- Hanya role 1 dan 2 bisa akses menu User --}}
                        @if (in_array(Auth::user()->role_id, [1, 2]))
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Account</span>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('user') }}" aria-expanded="false">
                                    <span><i class="ti ti-typography"></i></span>
                                    <span class="hide-menu">User</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <a href="{{ route('logout') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>

                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                @yield('content')
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank"
                            class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a
                            href="https://themewagon.com">ThemeWagon</a></p>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
