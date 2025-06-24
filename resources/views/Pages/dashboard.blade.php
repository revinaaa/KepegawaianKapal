@extends('layouts.dashboard')

@section('content')
    @if (auth()->user()->role_id == 3)
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3">Selamat Datang, {{ auth()->user()->name }}</h4>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>NIK:</strong> {{ auth()->user()->nik }}</p>

                    <hr class="my-4">

                    @forelse($karyawans as $karyawan)
                        <h5 class="fw-semibold mb-3">Informasi Karyawan</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2"><strong>Nama:</strong> {{ $karyawan->nama }}</div>
                            <div class="col-md-6 mb-2"><strong>Jabatan:</strong> {{ $karyawan->jabatan->nama ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Area Kerja:</strong> {{ $karyawan->area_kerja ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Tempat & Tgl Lahir:</strong> {{ $karyawan->tempat_lahir ?? '-' }},
                                {{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d M Y') ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Usia:</strong> {{ $karyawan->usia }} tahun</div>
                            <div class="col-md-6 mb-2"><strong>No Telepon:</strong> {{ $karyawan->no_telepon ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Golongan Darah:</strong> {{ $karyawan->golongan_darah ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Jenis Kelamin:</strong> {{ $karyawan->jenis_kelamin ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Agama:</strong> {{ $karyawan->agama ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Alamat:</strong> {{ $karyawan->alamat ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Nama Kapal:</strong> {{ $karyawan->nama_kapal ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Tanggal Mulai Kerja:</strong>
                                {{ \Carbon\Carbon::parse($karyawan->doh)->format('d M Y') ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Nama Ibu:</strong> {{ $karyawan->nama_ibu ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>NIK Ibu:</strong> {{ $karyawan->nik_ibu ?? '-' }}</div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-semibold">Data Keluarga</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2"><strong>Status Pernikahan:</strong> {{ $karyawan->status_keluarga ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>No KK:</strong> {{ $karyawan->no_kk ?? '-' }}</div>

                            @if ($karyawan->status_keluarga == 'Menikah')
                                <div class="col-md-6 mb-2"><strong>Nama Istri:</strong> {{ $karyawan->nama_istri ?? '-' }}</div>
                                <div class="col-md-6 mb-2"><strong>NIK Istri:</strong> {{ $karyawan->nik_istri ?? '-' }}</div>
                            @endif

                            @if (!empty($karyawan->nama_anak_pertama))
                                <div class="col-md-6 mb-2"><strong>Nama Anak Pertama:</strong> {{ $karyawan->nama_anak_pertama }}</div>
                                <div class="col-md-6 mb-2"><strong>NIK Anak Pertama:</strong> {{ $karyawan->nik_anak_pertama }}</div>
                            @endif

                            @if (!empty($karyawan->nama_anak_kedua))
                                <div class="col-md-6 mb-2"><strong>Nama Anak Kedua:</strong> {{ $karyawan->nama_anak_kedua }}</div>
                                <div class="col-md-6 mb-2"><strong>NIK Anak Kedua:</strong> {{ $karyawan->nik_anak_kedua }}</div>
                            @endif

                            @if (!empty($karyawan->nama_anak_ketiga))
                                <div class="col-md-6 mb-2"><strong>Nama Anak Ketiga:</strong> {{ $karyawan->nama_anak_ketiga }}</div>
                                <div class="col-md-6 mb-2"><strong>NIK Anak Ketiga:</strong> {{ $karyawan->nik_anak_ketiga }}</div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-semibold">BPJS Kesehatan</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2"><strong>No Kartu:</strong> {{ $karyawan->bpjsKesehatan->no_kartu_bpjs_kesehatan ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Nama Peserta:</strong> {{ $karyawan->bpjsKesehatan->nama_peserta_bpjs_kesehatan ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Kelas Rawat:</strong> {{ $karyawan->bpjsKesehatan->kelas_rawat ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Tanggal Daftar:</strong>
                                {{ optional($karyawan->bpjsKesehatan)->tanggal_daftar_bpjs_kesehatan ? \Carbon\Carbon::parse($karyawan->bpjsKesehatan->tanggal_daftar_bpjs_kesehatan)->format('d M Y') : '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Status:</strong> {{ $karyawan->bpjsKesehatan->status_bpjs_kesehatan ?? '-' }}</div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-semibold">BPJS Ketenagakerjaan</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2"><strong>No Kartu:</strong> {{ $karyawan->bpjsKetenagakerjaan->no_kartu_bpjs_ketenagakerjaan ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Nama Peserta:</strong> {{ $karyawan->bpjsKetenagakerjaan->nama_peserta_bpjs_ketenagakerjaan ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Kelas Rawat:</strong> {{ $karyawan->bpjsKetenagakerjaan->kelas_rawat ?? '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Tanggal Daftar:</strong>
                                {{ optional($karyawan->bpjsKetenagakerjaan)->tanggal_daftar_bpjs_ketenagakerjaan ? \Carbon\Carbon::parse($karyawan->bpjsKetenagakerjaan->tanggal_daftar_bpjs_ketenagakerjaan)->format('d M Y') : '-' }}</div>
                            <div class="col-md-6 mb-2"><strong>Status:</strong> {{ $karyawan->bpjsKetenagakerjaan->status_bpjs_ketenagakerjaan ?? '-' }}</div>
                        </div>
                    @empty
                        <div class="alert alert-warning mt-3">Data karyawan belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @else
       
    @endif
@endsection
