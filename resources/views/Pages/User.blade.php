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

                    {{-- Judul --}}
                    <h5 class="card-title fw-semibold mb-4">List User</h5>

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
                                            <a href="{{ route('user.disetujui', $item->slug) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="bi bi-check2-all me-1"></i>Setujui
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editCuti{{ $item->slug }}">
                                                <i class="bi bi-pencil-square me1"></i>edit
                                            </button>
                                            <form action="{{ route('user.destroy', $item->slug) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash3 me-1"></i>hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editCuti{{ $item->slug }}" tabindex="-1"
                                        aria-labelledby="editCutiLabel{{ $item->slug }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> <!-- modal-lg supaya lebih lebar -->
                                            <div class="modal-content">
                                                <form action="{{ route('user.update', $item->slug) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Kolom kiri -->
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="username"
                                                                        class="form-label">Username</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" value="{{ $item->name }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="username" class="form-label">Role</label>
                                                                <select class="form-select" name="role_id" id="role_id"
                                                                    required>
                                                                    <option value="">-- Pilih Karyawan --</option>
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{ $role->id }}"
                                                                            {{ $item->role_id == $role->id ? 'selected' : '' }}>
                                                                            {{ $role->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" name="status" id="status"
                                                                    required>
                                                                    <option value="Cuti Tahunan"
                                                                        {{ $item->status == 'active' ? 'selected' : '' }}>
                                                                        Aktif</option>
                                                                    <option value="Cuti Sakit"
                                                                        {{ $item->status == 'inactive' ? 'selected' : '' }}>
                                                                        Nonaktif</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="username" class="form-label">Email</label>
                                                                    <input type="text" class="form-control"
                                                                        name="email" value="{{ $item->email }}"
                                                                        required>
                                                                </div>
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
@endsection
