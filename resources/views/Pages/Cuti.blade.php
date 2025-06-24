@extends('layouts.dashboard')
@section('content')
    <div class="row mb-4">
        <div class="col-md-20">
            <div class="card shadow-sm py-2 px-4 text-start h-8">
                <p class="text-uppercase fw-semibold text-muted mb-2">Jumlah Cuti</p>
                <h2 class="fw-bold text-danger mb-2">{{ $jumlahCuti }} Orang</h2>
                <p class="text-sm text-muted mb-0">{{ now()->year }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahCuti">
                            <i class="bi bi-plus-square me-1"></i> Tambah Cuti
                        </button>
                    </div>

                    {{-- Judul --}}
                    <h5 class="card-title fw-semibold mb-4">List Cuti</h5>

                    {{-- Form Search --}}
                    <form action="{{ route('cuti') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search here ..."
                                value="{{ request('search') }}">
                            <button class="btn btn-success" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            @if (request('search'))
                                <a href="{{ route('cuti') }}" class="btn btn-outline-secondary">Reset</a>
                            @endif
                        </div>
                    </form>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fw-semibold mb-1">lampiran</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Nama Karyawan</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">NIK</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Jenis Cuti</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Tanggal Mulai</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Tanggal Akhir</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Status</h6>
                                    </th>
                                    <th class="text-center align-top" style="width: 130px;">
                                        <h6 class="fw-semibold mb-1">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cutis as $item)
                                    <tr>
                                        <td>
                                            @if ($item->lampiran)
                                                <a href="{{ route('lihat.lampiran', $item->lampiran) }}" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    Lihat Lampiran
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">
                                                {{ $item->user ? $item->user->name : 'Tidak ada user' }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->jenis_cuti }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->tanggal_mulai }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->tanggal_akhir }}</h6>
                                        </td>
                                        {{-- <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->alasan }}</h6>
                                        </td> --}}
                                        <td>
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                switch ($item->status) {
                                                    case 'proses':
                                                        $badgeClass = 'bg-warning';
                                                        break;
                                                    case 'ditolak':
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    case 'diterima':
                                                        $badgeClass = 'bg-success';
                                                        break;
                                                }
                                            @endphp
                                            <h6 class="fw-semibold mb-1">
                                                <span
                                                    class="badge {{ $badgeClass }} rounded-3 fw-semibold">{{ $item->status }}</span>
                                            </h6>
                                        </td>
                                        <td>
                                            @if (Auth::user()->role_id == 1)
                                                @if (in_array($item->status, [null, 'menunggu', 'proses']))
                                                    <a href="{{ route('cuti.disetujui', $item->slug) }}"
                                                        class="btn btn-success btn-sm mb-1">
                                                        <i class="bi bi-check2-all me-1"></i> Disetujui
                                                    </a>
                                                    <a href="{{ route('cuti.ditolak', $item->slug) }}"
                                                        class="btn btn-warning btn-sm mb-1">
                                                        <i class="bi bi-person-x me-1"></i> Ditolak
                                                    </a>
                                                @elseif ($item->status === 'diterima')
                                                    <span class="badge bg-success d-block mb-1">Sudah Disetujui</span>
                                                @elseif ($item->status === 'ditolak')
                                                    <span class="badge bg-danger d-block mb-1">Sudah Ditolak</span>
                                                @endif
                                            @endif

                                            <a href="{{ route('cuti.profile', $item->slug) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye-fill me-1"></i>detail
                                            </a>
                                            <a href="{{ route('cuti.unduh.pdf', $item->slug) }}"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-download"></i> PDF
                                            </a>

                                            @if (in_array(Auth::user()->role_id, [1]))
                                                <button type="button" class="btn btn-success btn-sm mb-1"
                                                    data-bs-toggle="modal" data-bs-target="#editCuti{{ $item->slug }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>

                                                <form id="form-hapus-cuti-{{ $item->id }}"
                                                    action="{{ route('cuti.destroy', $item->slug) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                                        onclick="hapusCuti('{{ $item->id }}')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- cuti -->
<div class="modal fade" id="tambahCuti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="tambahCutiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahCutiLabel">Tambah Data Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Pilih karyawan -->
                        <div class="col-md-12">
                            <label for="nik" class="form-label">Nama Karyawan</label>
                            <select name="nik" class="form-select" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->nik }}">{{ $karyawan->nama }} - {{ $karyawan->nik }}</option>
                                @endforeach
                            </select>
                            @error('nik')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Jenis Cuti -->
                        <div class="col-md-6">
                            <label for="jenis_cuti" class="form-label">Jenis Cuti</label>
                            <select name="jenis_cuti" class="form-select" required>
                                <option value="">-- Pilih Jenis Cuti --</option>
                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                <option value="Cuti Sakit">Cuti Sakit</option>
                                <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                <option value="Cuti Haid">Cuti Haid</option>
                                <option value="Cuti Besar">Cuti Besar</option>
                                <option value="Cuti Menikah">Cuti Menikah</option>
                                <option value="Cuti Istri Melahirkan">Cuti Istri Melahirkan</option>
                                <option value="Cuti Kematian">Cuti Kematian</option>
                                <option value="Cuti Keagamaan">Cuti Keagamaan</option>
                                <option value="Cuti Tanpa Gaji">Cuti Tanpa Gaji</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tanggal_akhir" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lampiran" class="form-label">Lampiran</label>
                            <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            @error('lampiran')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-bookmark-check-fill me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function hapusCuti(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Pengajuan cuti ini akan dihapus secara permanen tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-cuti-' + id).submit();
                }
            });
        }
    </script>
    {{-- @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif --}}
@endsection
