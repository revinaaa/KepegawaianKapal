@extends('layouts.dashboard')
@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Data Karyawan</h5>
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
                <form action="{{ route('registrasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama User</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="status" value="active">
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold">Data Karyawan</h6>
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <!-- NIK -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>

                        <!-- Foto -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Area Kerja -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Area Kerja</label>
                            <input type="text" name="area_kerja" class="form-control">
                        </div>

                        <!-- Pendidikan -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="pendidikan" class="form-control">
                        </div>

                        <!-- DOH -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai Kerja (DOH)</label>
                            <input type="date" name="doh" class="form-control">
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jabatan</label>
                            <select name="id_jabatan" class="form-select" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>

                        <!-- Usia -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usia</label>
                            <input type="number" name="usia" class="form-control">
                        </div>

                        <!-- No Telepon -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control">
                        </div>

                        <!-- Golongan Darah -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <!-- Agama -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control">
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control">
                        </div>

                        <!-- Nama Kapal -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Kapal</label>
                            <input type="text" name="nama_kapal" class="form-control">
                        </div>

                        <!-- Bank -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Bank</label>
                            <input type="text" name="jenis_bank" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No Akun Bank</label>
                            <input type="text" name="no_akun_bank" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Akun Bank</label>
                            <input type="text" name="nama_akun_bank" class="form-control">
                        </div>

                        <!-- Pajak -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Pajak</label>
                            <input type="text" name="kode_pajak" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <!-- No Telepon Darurat -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No Telepon Darurat</label>
                            <input type="text" name="no_telepon_darurat" class="form-control">
                        </div>
                        <!-- Status Keluarga -->
                        <div class="col-md-6 mb-3">
                            <label for="status_keluarga" class="form-label">Status Keluarga</label>
                            <select name="status_keluarga" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                            </select>
                        </div>

                        <!-- No KK -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No Kartu Keluarga</label>
                            <input type="text" name="no_kk" class="form-control">
                        </div>

                        <!-- Nama Ibu -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control">
                        </div>

                        <!-- NIK Ibu -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Ibu</label>
                            <input type="text" name="nik_ibu" class="form-control">
                        </div>

                        <!-- Data Keluarga -->
                        <hr class="my-4">
                        <h6 class="fw-bold">Data Keluarga</h6>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Istri</label>
                            <input type="text" name="nama_istri" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Istri</label>
                            <input type="text" name="nik_istri" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Anak Pertama</label>
                            <input type="text" name="nama_anak_pertama" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Anak Pertama</label>
                            <input type="text" name="nik_anak_pertama" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Anak Kedua</label>
                            <input type="text" name="nama_anak_kedua" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Anak Kedua</label>
                            <input type="text" name="nik_anak_kedua" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Anak Ketiga</label>
                            <input type="text" name="nama_anak_ketiga" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Anak Ketiga</label>
                            <input type="text" name="nik_anak_ketiga" class="form-control">
                        </div>

                        {{-- <hr class="my-4">
                        <h6 class="fw-bold">Data BPJS Kesehatan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label class="form-label">No Kartu BPJS Kesehatan</label>
                            <input type="text" name="no_kartu_kes" class="form-control"
                             value="{{ old('no_kartu_kes', $karyawan->no_kartu_kes ?? '') }}">
                        </div> --}}
                        {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">No Kartu BPJS Kesehatan</label>
                                <input type="number" name="no_kartu_kes" class="form-control"
                                    value="{{ old('no_kartu_kes', $karyawan->no_kartu_kes ?? '') }}">
                            </div> --}}
                        {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Peserta BPJS Kesehatan</label>
                                <input type="text" name="nama_kes" class="form-control"
                                    value="{{ old('nama_kes', $karyawan->nama_kes ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas Rawat</label>
                                <select name="kelas_rawat_kes" class="form-select">
                                    <option value="">-- Pilih Kelas Rawat --</option>
                                    <option value="Kelas 1"
                                        {{ old('kelas_rawat_kes', $karyawan->kelas_rawat_kes ?? '') == 'Kelas 1' ? 'selected' : '' }}>
                                        Kelas 1</option>
                                    <option value="Kelas 2"
                                        {{ old('kelas_rawat_kes', $karyawan->kelas_rawat_kes ?? '') == 'Kelas 2' ? 'selected' : '' }}>
                                        Kelas 2</option>
                                    <option value="Kelas 3"
                                        {{ old('kelas_rawat_kes', $karyawan->kelas_rawat_kes ?? '') == 'Kelas 3' ? 'selected' : '' }}>
                                        Kelas 3</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Daftar BPJS Kesehatan</label>
                                <input type="date" name="tanggal_daftar_kes" class="form-control"
                                    value="{{ old('tanggal_daftar_kes', $karyawan->tanggal_daftar_kes ?? '') }}">
                            </div> --}}
                        {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">Status BPJS Kesehatan</label>
                                <select name="status_bpjs_kes" class="form-select">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif"
                                        {{ old('status_bpjs_kes', $karyawan->status_bpjs_kes ?? '') == 'Aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="Nonaktif"
                                        {{ old('status_bpjs_kes', $karyawan->status_bpjs_kes ?? '') == 'Nonaktif' ? 'selected' : '' }}>
                                        Nonaktif</option>
                                </select>
                            </div> --}}

                        {{-- <h6 class="fw-bold">Data BPJS Ketenagakerjaan</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Kartu BPJS Ketenagakerjaan</label>
                                    <input type="number" name="no_kartu_kerja" class="form-control"
                                        value="{{ old('no_kartu_kerja', $karyawan->no_kartu_kerja ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Peserta BPJS Ketenagakerjaan</label>
                                    <input type="text" name="nama_kerja" class="form-control"
                                        value="{{ old('nama_kerja', $karyawan->nama_kerja ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelas Rawat</label>
                                    <select name="kelas_rawat_kerja" class="form-select">
                                        <option value="">-- Pilih Kelas Rawat --</option>
                                        <option value="Kelas 1"
                                            {{ old('kelas_rawat_kerja', $karyawan->kelas_rawat_kerja ?? '') == 'Kelas 1' ? 'selected' : '' }}>
                                            Kelas 1</option>
                                        <option value="Kelas 2"
                                            {{ old('kelas_rawat_kerja', $karyawan->kelas_rawat_kerja ?? '') == 'Kelas 2' ? 'selected' : '' }}>
                                            Kelas 2</option>
                                        <option value="Kelas 3"
                                            {{ old('kelas_rawat_kerja', $karyawan->kelas_rawat_kerja ?? '') == 'Kelas 3' ? 'selected' : '' }}>
                                            Kelas 3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Daftar BPJS Ketenagakerjaan</label>
                                    <input type="date" name="tanggal_daftar_kerja" class="form-control"
                                        value="{{ old('tanggal_daftar_kerja', $karyawan->tanggal_daftar_kerja ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status BPJS Ketenagakerjaan</label>
                                    <select name="status_bpjs_kerja" class="form-select">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif"
                                            {{ old('status_bpjs_kerja', $karyawan->status_bpjs_kerja ?? '') == 'Aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="Nonaktif"
                                            {{ old('status_bpjs_kerja', $karyawan->status_bpjs_kerja ?? '') == 'Nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>
                            </div> --}}
                    </div>
                    @csrf
                    <div class="col-12 d-flex gap-2 justify-content-end mt-3">
                        <a href="{{ route('karyawan') }}" class="btn btn-danger">
                            <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Registrasi & Simpan
                        </button>
                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Search here...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
