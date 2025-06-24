@extends('layouts.dashboard')

@section('css')
    <style>
        body {
            background: #f8f9fa;
        }

        .profile-header {
            background: linear-gradient(to right, #0d6efd, #6610f2);
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .social-icons a {
            color: #495057;
            font-size: 20px;
            margin: 0 10px;
            transition: 0.3s;
        }

        .social-icons a:hover {
            color: #0d6efd;
        }
    </style>
@endsection

@section('content')
    <!-- Header Profile -->
<div class="profile-header">
    {{-- Foto karyawan --}}
    @if (!empty($cuti->karyawan->foto))
        <img src="{{ asset('storage/cover/' . $cuti->karyawan->foto) }}" alt="Avatar" class="profile-img mb-3">
    @else
        <img src="{{ asset('img/foto-tidak-ada.png') }}" alt="No Avatar" class="profile-img mb-3">
    @endif

   <h2 class="text-white">
    {{ $cuti->karyawan->nama ?? '-' }}
</h2>

<p class="lead">
    {{ $cuti->karyawan->jabatan->nama ?? '-' }}
</p>
</div>



    <!-- Info Detail -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <!-- Kartu Deskripsi -->
            <div class="col-md-8">
                <div class="card p-4 mb-4">
                    @if (session('success'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h5>Alasan</h5>
                    <p>
                        {{ $cuti->alasan }}
                    </p>

                    <!-- Tombol Aksi -->
                    
                     {{-- @if (in_array(Auth::user()->role_id, [1]))
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCuti{{ $cuti->slug }}">
                                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                                </button>
                                                <form id="form-hapus-cuti-{{ $cuti->id }}"
                                                    action="{{ route('cuti.destroy', $cuti->slug) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="hapusCuti('{{ $cuti->id }}')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif --}}
                </div>
            </div>

            <!-- Kartu Kontak -->
            <div class="col-md-4">
                <div class="card p-4 mb-4">
                    <h5>About</h5>
                    <ul class="list-unstyled mb-2">
                        <li><strong>Jenis Cuti: </strong>{{ $cuti->jenis_cuti }}</li>
                        <li><strong>Tangal Cuti: </strong>{{ $cuti->tanggal_mulai }} Sampai {{ $cuti->tanggal_akhir }}</li>
                        <li><strong>Email:</strong>{{ $cuti->email }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
