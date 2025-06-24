@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow p-4">
                <h4 class="fw-semibold mb-4">Laporan Rekapitulasi Data</h4>

                {{-- Alert sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Ringkasan Statistik --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card company-card p-3">
                            <h6>Total Karyawan</h6>
                            <h4 class="fw-bold">{{ $jumlahKaryawan }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card company-card p-3">
                            <h6>Cuti Proses</h6>
<h4 class="fw-bold">{{ $cutiPending }}</h4>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card company-card p-3">
                            <h6>Cuti Disetujui</h6>
                            <h4 class="fw-bold">{{ $cutiDisetujui }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card company-card p-3">
                            <h6>Cuti Ditolak</h6>
                            <h4 class="fw-bold">{{ $cutiDitolak }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card p-4">
                    <h4 class="mb-4">Jumlah Karyawan Berdasarkan Tanggal DOH</h4>

                    <form action="{{ route('karyawan.jumlahByTanggal') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="start" class="form-label">Dari Tanggal</label>
                            <input type="date" name="start" class="form-control" value="{{ old('start', $start) }}"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="end" class="form-label">Sampai Tanggal</label>
                            <input type="date" name="end" class="form-control" value="{{ old('end', $end) }}"
                                required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </form>

                    @if (!is_null($jumlah))
                        <div class="alert alert-info">
                            <strong>Jumlah karyawan</strong> yang mulai kerja dari <strong>{{ $start }}</strong>
                            sampai <strong>{{ $end }}</strong> adalah:
                            <span class="fw-bold text-primary">{{ $jumlah }} orang</span>
                        </div>
                    @endif
                    @if (!empty($karyawanList) && count($karyawanList) > 0)
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Jabatan</th>
                    <th>DOH</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawanList as $index => $karyawan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $karyawan->nama }}</td>
                        <td>{{ $karyawan->nik }}</td>
                        <td>{{ $karyawan->jabatan->nama ?? '-' }}</td>
                        <td>{{ $karyawan->doh }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

                </div>


                {{-- Tombol Aksi --}}
                {{-- <div class="mb-4">
                    @if (auth()->user()->role->nama == 'admin' || auth()->user()->role->nama == 'hrd')
                        <a href="{{ route('karyawan.unduh.semua') }}" class="btn btn-success me-2">
                            <i class="bi bi-people-fill me-1"></i> Cetak Semua Data Karyawan
                        </a>
                    @endif

                    <a href="{{ route('cuti') }}" class="btn btn-primary">
                        <i class="bi bi-card-list me-1"></i> Lihat Detail Pengajuan Cuti
                    </a>
                </div>
            </div> --}}
            </div>
        </div>
    @endsection
