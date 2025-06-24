<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    <!-- Tambahan Styles -->
    @yield('styles')
    @yield('css')

    {{-- <style>
.navbar .dropdown-menu {
    position: absolute !important;
    top: 50px !important;
    right: 10px !important;
    left: auto !important;
    z-index: 9999 !important;
    transform: none !important;
}
</style> --}}
    <style>
        body {
            background-color: #eaf0f5;
            /* Latar belakang lembut */
            font-family: 'Poppins', sans-serif;
            color: #2f2f2f;
        }

        /* Sidebar lebih muda */
        .left-sidebar {
            background-color: #bcd4e6 !important;
            /* Biru muda pastel */
            color: #2f2f2f;
        }

        .left-sidebar a {
            color: #2f2f2f;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .left-sidebar a:hover,
        .left-sidebar .sidebar-item.active>.sidebar-link {
            background-color: #a5c3da;
            /* Hover biru pastel lebih gelap sedikit */
            color: #1f1f1f !important;
            border-radius: 8px;
            font-weight: 600;
        }

        .sidebar-link i {
            color: #2c3e50;
        }

        .sidebar-link:hover i {
            color: #1a1a1a;
        }

        /* Header */
        .app-header {
            background-color: #d9e7f0;
            /* Header biru keputihan */
            border-bottom: 1px solid #b5c7d8;
        }

        .navbar .nav-link,
        .navbar .company-name {
            color: #2e2e2e !important;
        }

        /* Company Card */
        .company-card {
            background: #ffffff;
            border: 1px solid #e0e6eb;
            border-radius: 12px;
            padding: 1rem;
            color: #333;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        }

        .company-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .datetime {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Tombol Utama */
        .btn-primary {
            background-color: #7ba8c9;
            border-color: #7ba8c9;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #6494b9;
            border-color: #6494b9;
        }

        /* Kartu Konten */
        .card {
            border-radius: 16px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border: none;
        }

        .container-fluid {
            padding-top: 24px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #aecde3;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #97bad4;
        }
    </style>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/PT_Masada_Jaya_Lines.png') }}" width="180"
                            alt="Logo">
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>

                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                         @if (Auth::user()->role_id === 3)
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>                       
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('dashboard') }}">
                                <i class="ti ti-layout-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        @endif

                        @if (in_array(Auth::user()->role_id, [1, 2]))
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Menu</span>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="{{ route('jabatan.list') }}"><i
                                        class="ti ti-article"></i><span class="hide-menu">Jabatan</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="{{ route('karyawan') }}"><i
                                        class="ti ti-file-description"></i><span class="hide-menu">Karyawan</span></a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('cuti') }}">
                                    <i class="ti ti-file"></i>
                                    <span class="hide-menu">Cuti</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('laporan') }}">
                                    <i class="ti ti-file"></i>
                                    <span class="hide-menu">Laporan</span>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->role_id === 3)
                            <li class="sidebar-item"><a class="sidebar-link" href="{{ route('ajukan.cuti') }}"><i
                                        class="ti ti-typography"></i><span class="hide-menu">Ajukan Cuti</span></a></li>
                        @endif

                        @if (in_array(Auth::user()->role_id, [1, 2]))
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Account</span>
                            </li>
                            <li class="sidebar-item"><a class="sidebar-link" href="{{ route('user') }}"><i
                                        class="ti ti-typography"></i><span class="hide-menu">User</span></a></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- Sidebar End -->

        <div class="body-wrapper">
            <!-- Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>

                        {{-- //nama perusahaan// --}}
                        <style>
                            .company-info {
                                padding-left: 1rem;
                            }

                            .company-name {
                                font-size: 1.25rem;
                                font-weight: 700;
                                color: #2c3e50;
                                margin-bottom: 0;
                            }

                            .datetime {
                                font-size: 0.85rem;
                                color: #6c757d;
                                margin-top: 2px;
                            }

                            .datetime i {
                                margin-right: 5px;
                            }
                        </style>

                        <div class="company-info">
                            <p class="company-name mb-0">PT Masada Jaya Lines</p>
                            <div class="datetime">
                                <i class="bi bi-clock"></i><span id="datetime"></span>
                            </div>
                        </div>

                        <script>
                            function updateDateTime() {
                                const now = new Date();
                                const options = {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',

                                };
                                document.getElementById('datetime').textContent = now.toLocaleString('id-ID', options);
                            }

                            setInterval(updateDateTime, 1000);
                            updateDateTime();
                        </script>



                        {{-- <!-- Notification -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover position-relative dropdown-toggle" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                                @php
                                    use App\Models\Cuti;
                                    $notifikasiCuti = Cuti::where('status', 'pending')
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get();
                                    $jumlahNotifikasi = $notifikasiCuti->count();
                                @endphp
                                @if ($jumlahNotifikasi > 0)
                                    <span
                                        class="position-absolute top-10 start-20 translate-middle badge rounded-pill bg-danger">
                                        {{ $jumlahNotifikasi }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 300px;">
                                <li class="dropdown-header fw-bold">Pengajuan Cuti Baru</li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @forelse ($notifikasiCuti as $cuti)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cuti') }}">
                                            {{ $cuti->user->karyawan->nama ?? 'Pegawai' }} mengajukan cuti
                                        </a>
                                    </li>
                                @empty
                                    <li><a class="dropdown-item text-muted">Tidak ada notifikasi</a></li>
                                @endforelse
                                <li><a class="dropdown-item text-center text-primary fw-bold"
                                        href="{{ route('cuti') }}">Lihat Semua</a></li>
                            </ul>
                        </li> --}}

                    </ul>

                    <!-- User Info -->
                    <div class="navbar-collapse px-3 justify-content-end">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item me-3">
                                <span
                                    class="fw-semibold text-dark">{{ Auth::user()->karyawan->nama ?? Auth::user()->email }}</span>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" id="logout-btn"
                                    class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Header End -->

            <!-- Main Content Start -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Main Content End -->
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert Logout -->
    <script>
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logout') }}";
                }
            });
        });
    </script>
    <script>
        // Cek apakah Bootstrap dropdown terdeteksi
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = new bootstrap.Dropdown(document.querySelector('[data-bs-toggle="dropdown"]'));
            console.log('Bootstrap dropdown initialized:', dropdown);
        });
    </script>

    @yield('scripts')
</body>

</html>
