@extends('layouts.dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm py-2 px-4 text-start h-8">
            <p class="text-uppercase fw-semibold text-muted mb-2">Jumlah BPJS Ketenagakerjaan</p>
            <h2 class="fw-bold text-primary mb-2">{{ $bpjsKetenagakerjaan->count() }} Orang</h2>
            <p class="text-sm text-muted mb-0">{{ now()->year }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            @if (session('success'))
                <div class="alert alert-primary alert-dismissible fade show m-4" role="alert">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan!
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card-body p-4">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBpjs">
                        <i class="bi bi-plus-square me-1"></i> Tambah BPJS
                    </button>
                </div>

                <h5 class="card-title fw-semibold mb-4">List BPJS Ketenagakerjaan</h5>

                <form action="{{ route('bpjs-ketenaga-kerjaan') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search here ..." value="{{ request('search') }}">
                        <button class="btn btn-success" type="submit"><i class="bi bi-search"></i></button>
                        @if (request('search'))
                            <a href="{{ route('bpjs-ketenaga-kerjaan') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </div>
                </form>

                @if ($bpjsKetenagakerjaan->isEmpty() && request('search'))
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i> Tidak ditemukan untuk pencarian:
                        <strong>"{{ request('search') }}"</strong>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>No</th>
                                <th>No Kartu</th>
                                <th>Nama</th>
                                <th>Kelas Rawat</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bpjsKetenagakerjaan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_kartu }}</td>
                                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $item->kelas_rawat }}</td>
                                    <td>{{ $item->tanggal_daftar }}</td>
                                    <td>{{ $item->status_bpjs }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editBPJS{{ $item->slug }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form id="form-hapus-bpjs-ketenagakerjaan-{{ $item->id }}" action="{{ route('bpjs-ketenaga.destroy', $item->slug) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusBpjsKetenagakerjaan('{{ $item->id }}')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editBPJS{{ $item->slug }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('bpjs-ketenaga.update', $item->slug) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data BPJS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Pilih NIK Karyawan</label>
                                                                <select class="form-select select-nik" name="nik" required>
                                                                    <option value="">-- Pilih Karyawan --</option>
                                                                    @foreach ($karyawans as $karyawan)
                                                                        <option value="{{ $karyawan->nik }}" {{ $karyawan->nik == $item->nik ? 'selected' : '' }}>
                                                                            {{ $karyawan->nik }} - {{ $karyawan->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">No Kartu</label>
                                                                <input type="text" class="form-control" name="no_kartu" value="{{ $item->no_kartu }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Kelas Rawat</label>
                                                                <input type="text" class="form-control" name="kelas_rawat" value="{{ $item->kelas_rawat }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Daftar</label>
                                                                <input type="date" class="form-control" name="tanggal_daftar" value="{{ $item->tanggal_daftar }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Status</label>
                                                                <select class="form-select" name="status_bpjs" required>
                                                                    <option value="Aktif" {{ $item->status_bpjs == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                                    <option value="Nonaktif" {{ $item->status_bpjs == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" type="submit">Update</button>
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

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahBpjs" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('bpjs-ketenaga.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data BPJS Ketenagakerjaan</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih NIK Karyawan</label>
                                <select class="form-select select-nik" name="nik" required>
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->nik }}">{{ $karyawan->nik }} - {{ $karyawan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Kartu</label>
                                <input type="number" class="form-control" name="no_kartu" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas Rawat</label>
                                <select class="form-select" name="kelas_rawat" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="Kelas 1">Kelas 1</option>
                                    <option value="Kelas 2">Kelas 2</option>
                                    <option value="Kelas 3">Kelas 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Daftar</label>
                                <input type="date" class="form-control" name="tanggal_daftar" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status BPJS</label>
                                <select class="form-select" name="status_bpjs" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function hapusBpjsKetenagakerjaan(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data BPJS akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-bpjs-ketenagakerjaan-' + id).submit();
            }
        });
    }

    $(document).ready(function () {
        $('#tambahBpjs .select-nik').select2({ dropdownParent: $('#tambahBpjs'), width: '100%' });

        @foreach ($bpjsKetenagakerjaan as $item)
            $('#editBPJS{{ $item->slug }}').on('shown.bs.modal', function () {
                $(this).find('.select-nik').select2({
                    dropdownParent: $('#editBPJS{{ $item->slug }}'),
                    width: '100%'
                });
            });
        @endforeach
    });
</script>
@endsection
