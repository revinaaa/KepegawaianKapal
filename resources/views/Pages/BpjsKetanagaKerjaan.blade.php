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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#tambahBpjs">
                            <i class="bi bi-plus-square me-1"></i> Tambah BPJS
                        </button>
                    </div>

                    {{-- Judul --}}
                    <h5 class="card-title fw-semibold mb-4">List BPJS Ketenaga Kerjaan</h5>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No Kartu</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kelas Rawat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Daftar</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bpjsketanagakerjaan  as $item)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->no_kartu }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->kelas_rawat }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->tanggal_daftar }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->status_bpjs }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editBPJS{{ $item->slug }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('bpjs-ketenaga.destroy', $item->slug) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editBPJS{{ $item->slug }}" tabindex="-1"
                                        aria-labelledby="editBPJSLabel{{ $item->slug }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('bpjs-ketenaga.update', $item->slug) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editBPJSLabel{{ $item->slug }}">Edit
                                                            Data BPJS</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="no_kartu_{{ $item->slug }}" class="form-label">No
                                                                Kartu</label>
                                                            <input type="text" class="form-control"
                                                                id="no_kartu_{{ $item->slug }}" name="no_kartu"
                                                                value="{{ $item->no_kartu }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama_{{ $item->slug }}"
                                                                class="form-label">Nama</label>
                                                            <input type="text" class="form-control"
                                                                id="nama_{{ $item->slug }}" name="nama"
                                                                value="{{ $item->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kelas_rawat_{{ $item->slug }}"
                                                                class="form-label">Kelas Rawat</label>
                                                            <input type="text" class="form-control"
                                                                id="kelas_rawat_{{ $item->slug }}" name="kelas_rawat"
                                                                value="{{ $item->kelas_rawat }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_daftar_{{ $item->slug }}"
                                                                class="form-label">Tanggal Daftar</label>
                                                            <input type="date" class="form-control"
                                                                id="tanggal_daftar_{{ $item->slug }}"
                                                                name="tanggal_daftar" value="{{ $item->tanggal_daftar }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status_bpjs_{{ $item->slug }}"
                                                                class="form-label">Status</label>
                                                            <select class="form-select" name="status_bpjs" required>
                                                                <option value="Aktif"
                                                                    {{ $item->status_bpjs == 'Aktif' ? 'selected' : '' }}>
                                                                    Aktif</option>
                                                                <option value="Nonaktif"
                                                                    {{ $item->status_bpjs == 'Nonaktif' ? 'selected' : '' }}>
                                                                    Nonaktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-1"></i> Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-bookmark-check-fill me-1"></i> Update
                                                        </button>
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

    <!-- Modal Tambah BPJS Kesehatan -->
    <div class="modal fade" id="tambahBpjs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tambahBpjsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('bpjs-ketenaga.stroe') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahBpjsLabel">Tambah Data BPJS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="no_kartu" class="form-label">No Kartu</label>
                            <input type="text" class="form-control" id="no_kartu" name="no_kartu" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_rawat" class="form-label">Kelas Rawat</label>
                            <select class="form-select" id="kelas_rawat" name="kelas_rawat" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="Kelas 1">Kelas 1</option>
                                <option value="Kelas 2">Kelas 2</option>
                                <option value="Kelas 3">Kelas 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                            <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="status_bpjs" class="form-label">Status BPJS</label>
                            <select class="form-select" id="status_bpjs" name="status_bpjs" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
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
