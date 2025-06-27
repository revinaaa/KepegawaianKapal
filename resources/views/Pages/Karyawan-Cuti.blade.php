@extends('layouts.dashboard')

@section('content')
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
                            <i class="bi bi-plus-square me-1"></i> Ajukan Cuti
                        </button>
                    </div>

                    {{-- Judul --}}
                    <h5 class="card-title fw-semibold mb-4">Pengajuan Cuti</h5>
                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    {{-- <th>
                    <h6 class="fw-semibold mb-1">No</h6>
                </th> --}}
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
                                        {{-- <td>
                        <h6 class="fw-semibold mb-1">{{ $loop->iteration }}</h6>
                    </td> --}}
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
                                            <h6 class="fw-semibold mb-1">{{ $item->karyawan->nama ?? '-' }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->karyawan->nik ?? '-' }}</h6>
                                        </td>

                                        {{-- <h6 class="fw-semibold mb-1">{{ Auth::user()->name }}</h6>
                    </td>
                    <td>
                        <h6 class="fw-semibold mb-1">{{ $item->karyawan->nik ?? '-' }}</h6> --}}
                                        {{-- </td> --}}
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->jenis_cuti }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->tanggal_mulai }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->tanggal_akhir }}</h6>
                                        </td>
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
                                        <td class="text-center align-top">
                                            {{-- Tombol Detail selalu tampil --}}
                                            <div class="d-flex flex-column gap-2">
                                                {{-- <a href="{{ route('cuti.profile', $item->slug) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye-fill me-1"></i>detail
                                                </a> --}}
                                                <a href="{{ route('cuti.unduh.pdf', $item->slug) }}"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-download"></i> PDF
                                                </a>
                                            </div>

                                            {{-- <form action="{{ route('ajukan.destroy', $item->slug) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash3 me-1"></i>hapus
                            </button>
                        </form> --}}

                                            @if (Auth::user()->role && (Auth::user()->role->id == 1 || Auth::user()->role->id == 2))
                                                <a href="{{ route('cuti.disetujui', $item->slug) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="bi bi-check2-all me-1"></i>Disetujui
                                                </a>
                                                <a href="{{ route('cuti.ditolak', $item->slug) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-person-x me-1"></i>Ditolak
                                                </a>
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCuti{{ $item->slug }}">
                                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editCuti{{ $item->slug }}" tabindex="-1"
                                        aria-labelledby="editCutiLabel{{ $item->slug }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> <!-- modal-lg supaya lebih lebar -->
                                            <div class="modal-content">
                                                <form action="{{ route('cuti.update', $item->slug) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Kolom kiri -->
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="jenis_cuti" class="form-label">Jenis
                                                                        Cuti</label>
                                                                    <select class="form-select" name="jenis_cuti"
                                                                        id="jenis_cuti" required>
                                                                        <option value="Cuti Tahunan"
                                                                            {{ $item->jenis_cuti == 'Cuti Tahunan' ? 'selected' : '' }}>
                                                                            Cuti Tahunan</option>
                                                                        <option value="Cuti Sakit"
                                                                            {{ $item->jenis_cuti == 'Cuti Sakit' ? 'selected' : '' }}>
                                                                            Cuti Sakit</option>
                                                                        <option value="Cuti Melahirkan"
                                                                            {{ $item->jenis_cuti == 'Cuti Melahirkan' ? 'selected' : '' }}>
                                                                            Cuti Melahirkan</option>
                                                                        <option value="Cuti Haid"
                                                                            {{ $item->jenis_cuti == 'Cuti Haid' ? 'selected' : '' }}>
                                                                            Cuti Haid</option>
                                                                        <option value="Cuti Besar"
                                                                            {{ $item->jenis_cuti == 'Cuti Besar' ? 'selected' : '' }}>
                                                                            Cuti Besar</option>
                                                                        <option value="Cuti Menikah"
                                                                            {{ $item->jenis_cuti == 'Cuti Menikah' ? 'selected' : '' }}>
                                                                            Cuti Menikah</option>
                                                                        <option value="Cuti Istri Melahirkan"
                                                                            {{ $item->jenis_cuti == 'Cuti Istri Melahirkan' ? 'selected' : '' }}>
                                                                            Cuti Melahirkan</option>
                                                                        <option value="Cuti Kematian"
                                                                            {{ $item->jenis_cuti == 'Cuti Kematian' ? 'selected' : '' }}>
                                                                            Cuti Kematian</option>
                                                                        <option value="Cuti Keagamaan"
                                                                            {{ $item->jenis_cuti == 'Cuti Keagamaan' ? 'selected' : '' }}>
                                                                            Cuti Keagamaan</option>
                                                                        <option value="Cuti Tanpa Gaji"
                                                                            {{ $item->jenis_cuti == 'Cuti Tanpa Gaji' ? 'selected' : '' }}>
                                                                            Cuti Tanpa Gaji</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tanggal_mulai" class="form-label">Tanggal
                                                                        Mulai</label>
                                                                    <input type="date" class="form-control"
                                                                        name="tanggal_mulai"
                                                                        value="{{ $item->tanggal_mulai }}" required>
                                                                </div>
                                                            </div>
                                                            <!-- Kolom kanan -->
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="tanggal_akhir" class="form-label">Tanggal
                                                                        Akhir</label>
                                                                    <input type="date" class="form-control"
                                                                        name="tanggal_akhir"
                                                                        value="{{ $item->tanggal_akhir }}" required>
                                                                </div>
                                                                {{-- <div class="mb-3">
                                                <label for="alasan" class="form-label">Alasan</label>
                                                <textarea class="form-control" name="alasan" required>{{ $item->alasan }}</textarea>
                                            </div> --}}
                                                                {{-- <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                                            </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Modal Tambah cuti -->
    <div class="modal fade" id="tambahCuti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tambahCutiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg untuk ukuran lebih lebar -->
            <div class="modal-content">
                <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahCutiLabel">Tambah Data Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="nik" class="form-label">Nama Karyawan</label>
                                <select name="nik" class="form-select" required>
                                    @foreach ($karyawans as $karyawan)
                                        @if ($karyawan->nik == Auth::user()->nik)
                                            <option value="{{ $karyawan->nik }}" selected>{{ $karyawan->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('nik')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_cuti" class="form-label">Jenis Cuti</label>
                                <select name="jenis_cuti" class="form-select" required>
                                    <option value="">-- Pilih Jenis Cuti --</option>
                                    <option value="Cuti Tahunan">Cuti Tahunan</option>
                                    <option value="Cuti Sakit">Cuti Sakit</option>
                                    <option value="Cuti Melahirkan">Cuti Perjalanan Dinas</option>
                                    <option value="Cuti Besar">Cuti Besar</option>
                                    <option value="Cuti Menikah">Cuti Menikah</option>
                                    <option value="Cuti Istri Melahirkan">Cuti Istri Melahirkan</option>
                                    <option value="Cuti Keagamaan">Cuti Khitanan Anak</option>
                                    <option value="Cuti Keagamaan">Cuti Baptis Anak</option>
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
                                <input type="file" name="lampiran" class="form-control"
                                    accept=".pdf,.jpg,.jpeg,.png">
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
