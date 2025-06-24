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
                    <form action="{{ route('karyawan.update', $karyawan->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <label for="user_id" class="form-label">Pilih User</label>
                                <select class="form-select" name="user_id" id="user_id" required>
                                    <option value="">-- Pilih User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <hr class="my-4">
                            <h6 class="fw-bold">Data Karyawan</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" name="foto" id="foto"
                                        class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    {{-- Tampilkan foto jika dalam mode edit dan foto tersedia --}}
                                    @if (isset($karyawan) && $karyawan->foto)
                                        <div class="mt-3">
                                            <img src="{{ asset('storage/cover/' . $karyawan->foto) }}" alt="Foto Karyawan"
                                                width="120" class="img-thumbnail mb-2">
                                            <a href="{{ asset('storage/cover/' . $karyawan->foto) }}"
                                                class="btn btn-sm btn-success" download>
                                                <i class="bi bi-download me-1"></i> Unduh Foto
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <!-- Nama -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', $karyawan->nama) }}" required>
                                </div>

                                <!-- NIK (readonly atau hidden jika tidak bisa diubah) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" value="{{ $karyawan->nik }}"
                                        readonly>
                                </div>

                                {{-- <!-- Foto -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Foto (Kosongkan jika tidak diubah)</label>
                                    <input type="file" name="foto"
                                        class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <!-- area kerja -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Area Kerja</label>
                                    <input type="text" name="area_kerja" class="form-control"
                                        value="{{ old('tempat_lahir', $karyawan->area_kerja) }}">
                                </div>

                                <!-- pendidikan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pendidiakn</label>
                                    <input type="text" name="pendidikan" class="form-control"
                                        value="{{ old('pendidikan', $karyawan->pendidikan) }}">
                                </div>

                                <!-- Doh -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai Kerja (DOH)</label>
                                    <input type="date" name="doh" class="form-control"
                                        value="{{ old('doh', $karyawan->doh) }}">
                                </div>

                                <!-- Jabatan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <select name="id_jabatan" class="form-select" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}"
                                                {{ $karyawan->id_jabatan == $jabatan->id ? 'selected' : '' }}>
                                                {{ $jabatan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}">
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}">
                                </div>

                                <!-- usia -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Usia</label>
                                    <input type="date" name="usia" class="form-control"
                                        value="{{ old('usia', $karyawan->usia) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon', $karyawan->no_telepon) }}">
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
                                    <label class="form-label">Agama</label>
                                    <input type="text" name="agama" class="form-control"
                                        value="{{ old('agama', $karyawan->agama) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" name="alamat" class="form-control"
                                        value="{{ old('alamat', $karyawan->alamat) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kapal</label>
                                    <input type="text" name="nama_kapal" class="form-control"
                                        value="{{ old('nama_kapal', $karyawan->nama_kapal) }}">
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
                                    <label class="form-label">Kode Pajak</label>
                                    <input type="text" name="kode_pajak" class="form-control"
                                        value="{{ old('kode_pajak', $karyawan->kode_pajak) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $karyawan->email) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Telepon Darurat</label>
                                    <input type="text" name="no_telepon_darurat" class="form-control"
                                        value="{{ old('no_telepon_darurat', $karyawan->no_telepon_darurat) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Keluarga</label>
                                    <select name="status_keluarga" class="form-select" required>
                                        <option value="">Pilih</option>
                                        <option value="Menikah"
                                            {{ $karyawan->status_keluarga == 'Menikah' ? 'selected' : '' }}>Menikah
                                        </option>
                                        <option value="Belum Menikah"
                                            {{ $karyawan->status_keluarga == 'Belum Menikah' ? 'selected' : '' }}>Belum
                                            Menikah</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No KK</label>
                                    <input type="text" name="no_kk" class="form-control"
                                        value="{{ old('no_kk', $karyawan->no_kk) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control"
                                        value="{{ old('nama_ibu', $karyawan->nama_ibu) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" class="form-control"
                                        value="{{ old('nik_ibu', $karyawan->nik_ibu) }}">
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold">Data Keluarga</h6>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Istri</label>
                                    <input type="text" name="nama_istri" class="form-control"
                                        value="{{ old('nama_istri', $karyawan->nama_istri) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Istri</label>
                                    <input type="text" name="nik_istri" class="form-control"
                                        value="{{ old('nik_istri', $karyawan->nik_istri) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Anak Pertama</label>
                                    <input type="text" name="nama_anak_pertama" class="form-control"
                                        value="{{ old('nama_anak_pertama', $karyawan->nama_anak_pertama) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Anak Pertama</label>
                                    <input type="text" name="nik_anak_pertama" class="form-control"
                                        value="{{ old('nik_anak_pertama', $karyawan->nik_anak_pertama) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Anak Kedua</label>
                                    <input type="text" name="nama_anak_kedua" class="form-control"
                                        value="{{ old('nama_anak_kedua', $karyawan->nama_anak_kedua) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Anak Kedua</label>
                                    <input type="text" name="nik_anak_kedua" class="form-control"
                                        value="{{ old('nik_anak_kedua', $karyawan->nik_anak_kedua) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Anak Ketiga</label>
                                    <input type="text" name="nama_anak_ketiga" class="form-control"
                                        value="{{ old('nama_anak_ketiga', $karyawan->nama_anak_ketiga) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Anak Ketiga</label>
                                    <input type="text" name="nik_anak_ketiga" class="form-control"
                                        value="{{ old('nik_anak_ketiga', $karyawan->nik_anak_ketiga) }}">
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold">Data BPJS Kesehatan</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">No Kartu BPJS Kesehatan</label>
                                        <input type="number" name="no_kartu_bpjs_kesehatan" class="form-control"
                                            value="{{ old('no_kartu_bpjs_kesehatan', $karyawan->no_kartu_bpjs_kesehatan) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Peserta BPJS Kesehatan</label>
                                        <input type="text" name="nama_peserta_bpjs_kesehatan" class="form-control"
                                            value="{{ old('nama_peserta_bpjs_kesehatan', $karyawan->nama_peserta_bpjs_kesehatan) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kelas Rawat</label>
                                        <select name="kelas_rawat" class="form-select">
                                            <option value="">-- Pilih Kelas Rawat --</option>
                                            @foreach (['Kelas 1', 'Kelas 2', 'Kelas 3'] as $kelas)
                                                <option value="{{ $kelas }}"
                                                    {{ $karyawan->kelas_rawat == $kelas ? 'selected' : '' }}>
                                                    {{ $kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Daftar BPJS Kesehatan</label>
                                        <input type="date" name="tanggal_daftar_bpjs_kesehatan" class="form-control"
                                            value="{{ old('tanggal_daftar_bpjs_kesehatan', $karyawan->tanggal_daftar_bpjs_kesehatan) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status BPJS Kesehatan</label>
                                        <select name="status_bpjs_kesehatan" class="form-select">
                                            <option value="Aktif"
                                                {{ $karyawan->status_bpjs_kesehatan == 'Aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="Nonaktif"
                                                {{ $karyawan->status_bpjs_kesehatan == 'Nonaktif' ? 'selected' : '' }}>
                                                Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h6 class="fw-bold">Data BPJS Ketenagakerjaan</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">No Kartu BPJS Ketenagakerjaan</label>
                                        <input type="number" name="no_kartu_bpjs_ketenagakerjaan" class="form-control"
                                            value="{{ old('no_kartu_bpjs_ketenagakerjaan', $karyawan->no_kartu_bpjs_ketenagakerjaan) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Peserta BPJS Ketenagakerjaan</label>
                                        <input type="text" name="nama_peserta_bpjs_ketenagakerjaan"
                                            class="form-control"
                                            value="{{ old('nama_peserta_bpjs_ketenagakerjaan', $karyawan->nama_peserta_bpjs_ketenagakerjaan) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kelas Rawat</label>
                                        <select name="kelas_rawat_ketenagakerjaan" class="form-select">
                                            <option value="">-- Pilih Kelas Rawat --</option>
                                            @foreach (['Kelas 1', 'Kelas 2', 'Kelas 3'] as $kelas)
                                                <option value="{{ $kelas }}"
                                                    {{ $karyawan->kelas_rawat_ketenagakerjaan == $kelas ? 'selected' : '' }}>
                                                    {{ $kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Daftar BPJS Ketenagakerjaan</label>
                                        <input type="date" name="tanggal_daftar_bpjs_ketenagakerjaan"
                                            class="form-control"
                                            value="{{ old('tanggal_daftar_bpjs_ketenagakerjaan', $karyawan->tanggal_daftar_bpjs_ketenagakerjaan) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status BPJS Ketenagakerjaan</label>
                                        <select name="status_bpjs_ketenagakerjaan" class="form-select">
                                            <option value="Aktif"
                                                {{ $karyawan->status_bpjs_ketenagakerjaan == 'Aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="Nonaktif"
                                                {{ $karyawan->status_bpjs_ketenagakerjaan == 'Nonaktif' ? 'selected' : '' }}>
                                                Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

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
{{-- Select2 CDN --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "-- Pilih User --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
