<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan - {{ $karyawan->nama }}</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 60px;
            margin-right: 15px;
        }
        .kop-text h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .kop-text p {
            margin: 0;
            font-size: 11px;
        }
        h4 {
            background-color: #f0f0f0;
            padding: 6px;
            margin-top: 30px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 15px;
        }
        th {
            background-color: #f9f9f9;
            text-align: left;
            padding: 6px;
            font-weight: bold;
            border: 1px solid #ddd;
            width: 30%;
        }
        td {
            padding: 6px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <img src="{{ asset('storage/logo/PT_Masada_Jaya_Lines.png') }}" alt="Logo">
        <div class="kop-text">
            <h2>PT MASADA JAYA LINES</h2>
            <p><strong>SIUPAL No.:</strong> BXXV 440 / AL-58</p>
            <p>Jl Kapten Pierre Tendean No.174 RT.014 Kel. Seberang Mesjid Kec. Banjarmasin Tengah</p>
            <p>Kota Banjarmasin 70231 - Tel. +62511 3261257</p>
        </div>
    </div>

    <h4>Informasi Akun & Pribadi</h4>
@if ($karyawan->foto)
    <div style="text-align: center; margin: 20px 0;">
        <img 
            src="{{ public_path('storage/cover/' . $karyawan->foto) }}" 
            alt="Foto Karyawan"
            style="
                width: 80px; /* diperkecil dari 120px */
                height: auto;
                border: 1px solid #ccc;
                border-radius: 6px;
                padding: 3px;
                box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            "
        >
        <p style="margin-top: 6px; font-size: 11px; color: #555;"></p>
    </div>
@endif
    <table>
        <tr><th>Nama</th><td>{{ $karyawan->nama }}</td></tr>
        <tr><th>NIK</th><td>{{ $karyawan->nik }}</td></tr>
        <tr><th>Area Kerja</th><td>{{ $karyawan->area_kerja }}</td></tr>
        <tr><th>Jabatan</th><td>{{ $karyawan->jabatan->nama ?? '-' }}</td></tr>
        <tr><th>Tempat, Tanggal Lahir</th><td>{{ $karyawan->tempat_lahir }}, {{ $karyawan->tanggal_lahir }}</td></tr>
        <tr><th>Jenis Kelamin</th><td>{{ $karyawan->jenis_kelamin }}</td></tr>
        <tr><th>Golongan Darah</th><td>{{ $karyawan->golongan_darah }}</td></tr>
        <tr><th>Agama</th><td>{{ $karyawan->agama }}</td></tr>
        <tr><th>Nama Kapal</th><td>{{ $karyawan->nama_kapal }}</td></tr>
        <tr><th>No Telepon</th><td>{{ $karyawan->no_telepon }}</td></tr>
        <tr><th>Email</th><td>{{ $karyawan->email }}</td></tr>
        <tr><th>Pendidikan</th><td>{{ $karyawan->pendidikan }}</td></tr>
        <tr><th>Tanggal Mulai Kerja (DOH)</th><td>{{ $karyawan->doh }}</td></tr>
        <tr><th>Usia</th><td>{{ $karyawan->usia }}</td></tr>
        <tr><th>No Telepon Darurat</th><td>{{ $karyawan->no_telepon_darurat }}</td></tr>
        <tr><th>Status</th><td>{{ $karyawan->status_keluarga }}</td></tr>
    </table>

    <h4>Data Bank & Pajak</h4>
    <table>
        <tr><th>Jenis Bank</th><td>{{ $karyawan->jenis_bank }}</td></tr>
        <tr><th>No Akun Bank</th><td>{{ $karyawan->no_akun_bank }}</td></tr>
        <tr><th>Nama Akun Bank</th><td>{{ $karyawan->nama_akun_bank }}</td></tr>
        <tr><th>Kode Pajak</th><td>{{ $karyawan->kode_pajak }}</td></tr>
    </table>

    <h4>Data Keluarga</h4>
<table>
    <tr><th>No KK</th><td>{{ $karyawan->no_kk ?? '-' }}</td></tr>
    <tr><th>Nama Ibu</th><td>{{ $karyawan->nama_ibu ?? '-' }}</td></tr>
    <tr><th>NIK Ibu</th><td>{{ $karyawan->nik_ibu ?? '-' }}</td></tr>
    <tr><th>Nama Istri</th><td>{{ $karyawan->nama_istri ?? '-' }}</td></tr>
    <tr><th>NIK Istri</th><td>{{ $karyawan->nik_istri ?? '-' }}</td></tr>
    <tr><th>Nama Anak Pertama</th><td>{{ $karyawan->nama_anak_pertama ?? '-' }}</td></tr>
    <tr><th>NIK Anak Pertama</th><td>{{ $karyawan->nik_anak_pertama ?? '-' }}</td></tr>
    <tr><th>Nama Anak Kedua</th><td>{{ $karyawan->nama_anak_kedua ?? '-' }}</td></tr>
    <tr><th>NIK Anak Kedua</th><td>{{ $karyawan->nik_anak_kedua ?? '-' }}</td></tr>
    <tr><th>Nama Anak Ketiga</th><td>{{ $karyawan->nama_anak_ketiga ?? '-' }}</td></tr>
    <tr><th>NIK Anak Ketiga</th><td>{{ $karyawan->nik_anak_ketiga ?? '-' }}</td></tr>
</table>


    <h4>BPJS Kesehatan</h4>
    <table>
        <tr><th>No Kartu</th><td>{{ $karyawan->no_kartu ?? '-' }}</td></tr>
        <tr><th>Nama Peserta</th><td>{{ $karyawan->nama ?? '-' }}</td></tr>
        <tr><th>Kelas Rawat</th><td>{{ $karyawan->kelas_rawat ?? '-' }}</td></tr>
        <tr><th>Tanggal Daftar</th><td>{{ $karyawan->tanggal_daftar ?? '-' }}</td></tr>
        <tr><th>Status</th><td>{{ $karyawan->status ?? '-' }}</td></tr>
    </table>

    <h4>BPJS Ketenagakerjaan</h4>
    <table>
        <tr><th>No Kartu</th><td>{{ $karyawan->no_kartu ?? '-' }}</td></tr>
        <tr><th>Nama Peserta</th><td>{{ $karyawan->nama ?? '-' }}</td></tr>
        <tr><th>Kelas Rawat</th><td>{{ $karyawan->kelas_rawat ?? '-' }}</td></tr>
        <tr><th>Tanggal Daftar</th><td>{{ $karyawan->tanggal_daftar ?? '-' }}</td></tr>
        <tr><th>Status</th><td>{{ $karyawan->status ?? '-' }}</td></tr>
    </table>

</body>
</html>
