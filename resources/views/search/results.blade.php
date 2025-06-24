@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Hasil Pencarian</h2>

        @if($results->isEmpty())
            <div class="alert alert-warning">Tidak ada data yang ditemukan.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Area Kerja</th>
                        <th>Posisi</th>
                        <th>No Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $pegawai)
                        <tr>
                            <td>{{ $pegawai->nama }}</td>
                            <td>{{ $pegawai->area_kerja }}</td>
                            <td>{{ $pegawai->jabatan->nama ?? '-' }}</td>
                            <td>{{ $pegawai->no_telepon }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('search.index') }}" class="btn btn-secondary mt-3">Kembali ke pencarian</a>
    </div>
@endsection
