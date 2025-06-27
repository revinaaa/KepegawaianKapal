<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Cuti - {{ $cuti->karyawan->nama ?? 'Nama Tidak Ditemukan' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            color: #000;
            margin: 1.8cm;
            line-height: 1.35;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 1.5px solid #000;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        .kop-surat img {
            width: 70px;
            height: auto;
            margin-right: 12px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 15pt;
            font-weight: bold;
        }

        .kop-text p {
            margin: 1.5px 0;
            font-size: 9.5pt;
        }

        .judul-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-surat h3 {
            margin: 0;
            font-size: 12.5pt;
            text-decoration: underline;
            font-weight: bold;
        }

        .judul-surat p {
            margin: 0;
            font-size: 10pt;
        }

        .isi-surat {
            text-align: justify;
        }

        .isi-surat p {
            margin: 4px 0;
        }

        .isi-surat table {
            margin: 8px 0 15px;
            font-size: 10.5pt;
        }

        .isi-surat td {
            vertical-align: top;
            padding: 2px 0;
        }

        .status-highlight {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            text-transform: uppercase;
            margin: 10px 0;
        }

        .ttd-kanan {
            margin-top: 30px;
            text-align: right;
        }

        .ttd-kanan p {
            margin: 2px 0;
        }

        .ttd-kanan .nama-ttd {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Kop Surat -->
   <table width="100%" style="border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px;">
    <tr>
        <td style="width: 80px;">
            <img src="{{ $logoBase64 }}" alt="Logo" style="width: 80px;">
        </td>
        <td style="text-align: left;">
            <h2 style="margin: 0; font-size: 18px; text-transform: uppercase;">PT MASADA JAYA LINES</h2>
            <p style="margin: 2px 0; font-size: 12px;"><strong>SIUPAL No.:</strong> BXXV 440 / AL-58</p>
            <p style="margin: 2px 0; font-size: 12px;">Jl Kapten Pierre Tendean No.174 RT.014 Kel. Seberang Mesjid Kec. Banjarmasin Tengah</p>
            <p style="margin: 2px 0; font-size: 12px;">Kota Banjarmasin 70231 - Tel. +62511 3261257</p>
        </td>
    </tr>
</table>

    <!-- Judul Surat -->
    <div class="judul-surat">
        <h3>SURAT BALASAN PERMOHONAN CUTI</h3>
        @php
            use Carbon\Carbon;
            $id = $cuti->id ?? 0;
            $tanggal = Carbon::parse($cuti->created_at ?? now());
            $nomorSurat = sprintf('%03d', $id) . '/HRD-MJL/' . $tanggal->format('m/Y');
        @endphp
        <p>Nomor: {{ $nomorSurat }}</p>

    </div>

    <!-- Isi Surat -->
    <div class="isi-surat">
        <p>Kepada Yth,</p>
        <p><strong>Sdr/i. {{ $cuti->karyawan->nama ?? '-' }}</strong><br>
            NIK: {{ $cuti->nik }}<br>
            Di Tempat</p>

        <p>Dengan hormat,</p>

        <p>Menindaklanjuti permohonan cuti kerja yang Saudara/i ajukan, berikut kami sampaikan rincian permohonan:</p>

        <table>
            <tr>
                <td style="width: 150px;">Jenis Cuti</td>
                <td>: {{ $cuti->jenis_cuti }}</td>
            </tr>
            <tr>
                <td>Tanggal Mulai</td>
                <td>: {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Tanggal Akhir</td>
                <td>: {{ \Carbon\Carbon::parse($cuti->tanggal_akhir)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Alasan</td>
                <td>: {{ $cuti->alasan }}</td>
            </tr>
        </table>

        <p>Berdasarkan hasil evaluasi, maka permohonan cuti Saudara/i dinyatakan:</p>

        <div class="status-highlight">{{ strtoupper($cuti->status) }}</div>

        @if (strtolower($cuti->status) === 'disetujui')
            <p>Saudara/i dapat memanfaatkan waktu cuti sesuai jadwal. Harap kembali bekerja tepat waktu dalam kondisi
                sehat.</p>
        @elseif(strtolower($cuti->status) === 'ditolak')
            <p>Mohon maaf, permohonan cuti belum dapat disetujui dengan pertimbangan operasional. Silakan hubungi HRD
                untuk informasi lebih lanjut.</p>
        @else
            <p>Permohonan cuti masih dalam proses dan akan diinformasikan setelah mendapat keputusan final.</p>
        @endif

        <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerja sama Saudara/i, kami ucapkan terima kasih.</p>
    </div>

    <!-- Tanda Tangan HRD -->
    <div class="ttd-kanan">
        <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Hormat kami,</p>
        <p class="nama-ttd">Manajer<br>PT Masada Jaya Lines</p>
    </div>

</body>

</html>
