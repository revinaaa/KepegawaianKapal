@extends('layouts.dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-20">
            <div class="card shadow-sm py-2 px-4 text-start h-8">
                <p class="text-uppercase fw-semibold text-muted mb-2">Jumlah Pegawai</p>
                <h2 class="fw-bold text-primary mb-2">{{ $jumlahKaryawan }} Orang</h2>
                <p class="text-sm text-muted mb-0">2025</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">

                <meta name="csrf-token" content="{{ csrf_token() }}">

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-primary alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body p-4">
                    {{-- Tombol Tambah --}}
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('karyawan.add') }}" class="btn btn-primary">
                            <i class="bi bi-plus-square me-1"></i> Tambah Karyawan
                        </a>
                    </div>

                    {{-- Judul --}}
                    <h5 class="card-title fw-semibold mb-4">List Karyawan</h5>
                    <form action="{{ route('karyawan') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search here ..."
                                value="{{ request('search') }}">
                            <button class="btn btn-success" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            @if (request('search'))
                                <a href="{{ route('karyawan') }}" class="btn btn-outline-secondary">Reset</a>
                            @endif
                        </div>
                    </form>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Lahir</th>
                                    <th>No Telepon</th>
                                    <th>Aksi</th> <!-- Kolom Aksi -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($karyawans as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>
                                            @if (!empty($item->foto))
                                                <img src="{{ asset('storage/cover/' . $item->foto) }}" width="50"
                                                    height="50" class="rounded border">
                                            @else
                                                <img src="{{ asset('img/foto-tidak-ada.png') }}" width="50"
                                                    height="50" class="rounded border">
                                            @endif
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jabatan->nama ?? '-' }}</td>
                                        <td>{{ $item->tanggal_lahir }}</td>
                                        <td>{{ $item->no_telepon }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.edit', $item->slug) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            @if ($item->user)
                                                <form id="delete-form-{{ $item->nik }}" method="POST"
                                                    action="{{ route('hapus.karyawan.user', ['userId' => $item->nik, 'slug' => $item->slug]) }}"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-nik="{{ $item->nik }}"
                                                        data-slug="{{ $item->slug }}">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled
                                                    title="User tidak ditemukan">
                                                    Hapus
                                                </button>
                                            @endif

                                            <a href="{{ route('karyawan.unduh.pdf', $item->nik) }}"
                                                class="btn btn-sm btn-danger" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Card Body --}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const nik = this.getAttribute('data-nik');
                const slug = this.getAttribute('data-slug');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data user dan karyawan akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${nik}`).submit();
                    }
                });
            });
        });
    </script>
@endsection
