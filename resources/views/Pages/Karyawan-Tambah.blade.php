@extends('layouts.dashboard')

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
                <div class="card-body">
                    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No KK</label>
                                <input type="number" name="no_kk" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Area Kerja</label>
                                <input type="text" name="area_kerja" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai Kerja (DOH)</label>
                                <input type="date" name="doh" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <select name="id_jabatan" class="form-select" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kapal</label>
                                <input type="text" name="nama_kapal" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Telepon</label>
                                <input type="number" name="no_telepon" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">-- Pilih Golongan Darah --</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agama</label>
                                <input type="text" name="agama" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Bank</label>
                                <input type="text" name="jenis_bank" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Akun Bank</label>
                                <input type="number" name="no_akun_bank" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Akun Bank</label>
                                <input type="text" name="nama_akun_bank" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">BPJS Kesehatan</label>
                                <select name="id_bpjs_kesehatan" class="form-select">
                                    <option value="">-- Pilih BPJS Kesehatan --</option>
                                    @foreach ($bpjsKesehatan as $bpjs)
                                        <option value="{{ $bpjs->id }}">{{ $bpjs->no_kartu }} - {{ $bpjs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">BPJS Ketenagakerjaan</label>
                                <select name="id_bpjs_ketenagakerjaan" class="form-select">
                                    <option value="">-- Pilih BPJS Ketenagakerjaan --</option>
                                    @foreach ($bpjsKetenagakerjaan as $bpjs)
                                        <option value="{{ $bpjs->id }}">{{ $bpjs->no_kartu }} - {{ $bpjs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pajak</label>
                                <input type="text" name="kode_pajak" class="form-control">
                            </div>

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
