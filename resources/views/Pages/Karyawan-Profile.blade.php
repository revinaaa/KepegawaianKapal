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

        .info-table td {
            padding: 8px 10px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: 600;
            width: 160px;
            color: #495057;
        }
    </style>
@endsection

@section('content')
    <!-- Header Profile -->
    <div class="profile-header">
        <div>
            @if (!empty($cuti->karyawan->foto))
                <img src="{{ asset('storage/cover/' . $cuti->karyawan->foto) }}" alt="Avatar" class="profile-img mb-3">
            @else
                <img src="{{ asset('img/foto-tidak-ada.png') }}" alt="No Avatar" class="profile-img mb-3">
            @endif

            <h2 class="text-white">{{ $cuti->karyawan->nama ?? '-' }}</h2>
            <p class="lead">{{ $cuti->karyawan->jabatan->nama ?? '-' }}</p>
        </div>
    </div>

    <!-- Info Detail -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <!-- Aksi -->
            <div class="col-md-8">
                <div class="card p-4 mb-4">
                    @if (session('success'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (in_array(Auth::user()->role_id, [1]))
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editCuti{{ $cuti->slug }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>

                        <form id="form-hapus-cuti-{{ $cuti->id }}"
                            action="{{ route('cuti.destroy', $cuti->slug) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusCuti('{{ $cuti->id }}')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Detail Cuti -->
<div class="col-md-8">
    <div class="card p-4 mb-4 position-relative">
        <h5 class="mb-3">Pengajuan Cuti Anda</h5>
        <table class="table borderless info-table mb-0">
            <tr>
                <td>Jenis Cuti</td>
                <td>: {{ $cuti->jenis_cuti }}</td>
            </tr>
            <tr>
                <td>Tanggal Cuti</td>
                <td>: {{ $cuti->tanggal_mulai }} sampai {{ $cuti->tanggal_akhir }}</td>
            </tr>
            {{-- <tr>
                <td>Email</td>
                <td>: {{ $cuti->email }}</td>
            </tr> --}}
            <tr>
                <td>Status</td>
                <td>: 
                    <span class="badge 
                        {{ $cuti->status == 'diterima' ? 'bg-success' : ($cuti->status == 'ditolak' ? 'bg-danger' : 'bg-warning') }}">
                        {{ ucfirst($cuti->status) }}
                    </span>
                </td>
            </tr>
            @if ($cuti->lampiran)
                <tr>
                    <td>Lampiran</td>
                    <td>: 
                        <a href="{{ route('lihat.lampiran', $cuti->lampiran) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat
                        </a>
                    </td>
                </tr>
            @endif
        </table>

        <!-- Tombol Kembali di kanan atas bawah status -->
        <div class="text-end mt-3">
            <a href="{{ route('cuti') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
        </div>
    </div>
@endsection
