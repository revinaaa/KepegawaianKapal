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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJabatan">
                            <i class="bi bi-plus-square me-1"></i> Tambah Jabatan
                        </button>
                    </div>

                    {{-- Judul --}}
                    <h5 class="card-title fw-semibold mb-4">List Jabatan</h5>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0"><h6 class="fw-semibold mb-0">No</h6></th>
                                    <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Nama</h6></th>
                                    <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Aksi</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jabatans as $item)
                                    <tr>
                                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6></td>
                                        <td class="border-bottom-0"><h6 class="fw-semibold mb-1">{{ $item->nama }}</h6></td>
                                        <td class="border-bottom-0">
                                            {{-- Edit Button --}}
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editJabatan{{ $item->slug }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            {{-- Delete Button --}}
                                            <form id="form-hapus-{{ $item->slug }}"
                                                action="{{ route('jabatan.destroy', $item->slug) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapusJabatan('{{ $item->slug }}')">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="editJabatan{{ $item->slug }}" tabindex="-1"
                                        aria-labelledby="editJabatanLabel{{ $item->slug }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('jabatan.update', $item->slug) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editJabatanLabel{{ $item->slug }}">Edit Jabatan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="nama_jabatan_{{ $item->slug }}" class="form-label">Nama Jabatan</label>
                                                        <input type="text" class="form-control" id="nama_jabatan_{{ $item->slug }}"
                                                            name="nama" value="{{ $item->nama }}" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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

    {{-- Modal Tambah --}}
    <div class="modal fade" id="tambahJabatan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('jabatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Jabatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                            <input type="text" class="form-control" id="nama_jabatan" name="nama" required>
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
        function hapusJabatan(slug) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data jabatan yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + slug).submit();
                }
            });
        }
    </script>
@endsection
