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

                    {{-- Judul dan Tombol Tambah --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">List User</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahUser">
                            <i class="bi bi-plus-lg me-1"></i> Tambah User
                        </button>
                    </div>

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fw-semibold mb-1">No</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Username</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Email</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Status</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-1">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->name ?? '-' }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ $item->email }}</h6>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                switch ($item->status) {
                                                    case 'inactive':
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    case 'active':
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
                                            {{-- <a href="{{ route('user.disetujui', $item->slug) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="bi bi-check2-all me-1"></i>Setujui
                                            </a> --}}
                                            {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editUser{{ $item->slug }}">
                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                            </button> --}}
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('user.show', $item->slug) }}"
                                                class="btn btn-info btn-sm mb-1">
                                                <i class="bi bi-eye-fill me-1"></i> Detail
                                            </a>
                                            <form id="form-hapus-user-{{ $item->id }}"
                                                action="{{ route('user.destroy', $item->slug) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapusUser('{{ $item->id }}')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>


                                        </td>
                                    </tr>

                                    <!-- Modal Edit User -->
                                    <div class="modal fade" id="editUser{{ $item->slug }}" tabindex="-1"
                                        aria-labelledby="editUserLabel{{ $item->slug }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('user.update', $item->slug) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="name" class="form-label">Username</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $item->name }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="role_id" class="form-label">Role</label>
                                                                <select class="form-select" name="role_id" required>
                                                                    <option value="">-- Pilih Role --</option>
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{ $role->id }}"
                                                                            {{ $item->role_id == $role->id ? 'selected' : '' }}>
                                                                            {{ $role->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" name="status" required>
                                                                    <option value="active"
                                                                        {{ $item->status == 'active' ? 'selected' : '' }}>
                                                                        Aktif</option>
                                                                    <option value="inactive"
                                                                        {{ $item->status == 'inactive' ? 'selected' : '' }}>
                                                                        Nonaktif</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control" name="email"
                                                                    value="{{ $item->email }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update User</button>
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

    <!-- Modal Tambah User -->
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahUserLabel">Tambah User Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" required
                                    value="{{ old('nik') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Username</label>
                                <input type="text" class="form-control" name="name" required
                                    value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select class="form-select" name="role_id" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function hapusUser(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "User ini akan dihapus secara permanen tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-user-' + id).submit();
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
