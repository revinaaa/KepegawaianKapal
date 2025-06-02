@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Data Karyawan</h5>
            <div class="card">

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

                <div class="card-body">
                    <form action="{{ route('karyawan.update', $karyawan->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ old('nama', $karyawan->nama) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No KK</label>
                                <input type="text" name="no_kk" class="form-control"
                                    value="{{ old('no_kk', $karyawan->no_kk) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Area Kerja</label>
                                <input type="text" name="area_kerja" class="form-control"
                                    value="{{ old('area_kerja', $karyawan->area_kerja) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai Kerja (DOH)</label>
                                <input type="date" name="doh" class="form-control"
                                    value="{{ old('doh', $karyawan->doh) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <select name="id_jabatan" class="form-select" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}"
                                            {{ old('id_jabatan', $karyawan->id_jabatan) == $jabatan->id ? 'selected' : '' }}>
                                            {{ $jabatan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kapal</label>
                                <input type="text" name="nama_kapal" class="form-control"
                                    value="{{ old('nama_kapal', $karyawan->nama_kapal) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                    value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                    value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Telepon</label>
                                <input type="text" name="no_telepon" class="form-control"
                                    value="{{ old('no_telepon', $karyawan->no_telepon) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">-- Pilih Golongan Darah --</option>
                                    @foreach (['A', 'B', 'AB', 'O'] as $gol)
                                        <option value="{{ $gol }}"
                                            {{ old('golongan_darah', $karyawan->golongan_darah) == $gol ? 'selected' : '' }}>
                                            {{ $gol }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agama</label>
                                <input type="text" name="agama" class="form-control"
                                    value="{{ old('agama', $karyawan->agama) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Bank</label>
                                <input type="text" name="jenis_bank" class="form-control"
                                    value="{{ old('jenis_bank', $karyawan->jenis_bank) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Akun Bank</label>
                                <input type="number" name="no_akun_bank" class="form-control"
                                    value="{{ old('no_akun_bank', $karyawan->no_akun_bank) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Akun Bank</label>
                                <input type="text" name="nama_akun_bank" class="form-control"
                                    value="{{ old('nama_akun_bank', $karyawan->nama_akun_bank) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">BPJS Kesehatan</label>
                                <select name="id_bpjs_kesehatan" class="form-select">
                                    <option value="">-- Pilih BPJS Kesehatan --</option>
                                    @foreach ($bpjsKesehatan as $bpjs)
                                        <option value="{{ $bpjs->id }}"
                                            {{ old('id_bpjs_kesehatan', $karyawan->id_bpjs_kesehatan) == $bpjs->id ? 'selected' : '' }}>
                                            {{ $bpjs->no_kartu }} - {{ $bpjs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">BPJS Ketenagakerjaan</label>
                                <select name="id_bpjs_ketenagakerjaan" class="form-select">
                                    <option value="">-- Pilih BPJS Ketenagakerjaan --</option>
                                    @foreach ($bpjsKetenagakerjaan as $bpjs)
                                        <option value="{{ $bpjs->id }}"
                                            {{ old('id_bpjs_ketenagakerjaan', $karyawan->id_bpjs_ketenagakerjaan) == $bpjs->id ? 'selected' : '' }}>
                                            {{ $bpjs->no_kartu }} - {{ $bpjs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pajak</label>
                                <input type="text" name="kode_pajak" class="form-control"
                                    value="{{ old('kode_pajak', $karyawan->kode_pajak) }}">
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-bold">Data Keluarga</h6>

                            @php
                                $keluargaFields = [
                                    'nama_istri',
                                    'nik_istri',
                                    'nama_anak_pertama',
                                    'nik_anak_pertama',
                                    'nama_anak_kedua',
                                    'nik_anak_kedua',
                                    'nama_anak_ketiga',
                                    'nik_anak_ketiga',
                                ];
                            @endphp

                            @foreach ($keluargaFields as $field)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                    <input type="text" name="{{ $field }}" class="form-control"
                                        value="{{ old($field, $karyawan->$field) }}">
                                </div>
                            @endforeach

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-save me-1"></i> Perbarui Data
                                </button>
                                <a href="{{ route('karyawan') }}" class="btn btn-danger">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
