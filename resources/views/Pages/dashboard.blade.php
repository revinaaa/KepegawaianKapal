@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">List Pegawai</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Foto</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jabatan</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Kelamin</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No Telepon</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($karyawans as $item)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            @if ($item->foto != '')
                                                <img src="{{ asset('storage/cover/' . $item->foto) }}" alt="Avatar"
                                                    width="50" height="50"
                                                    class="rounded-lg object-fit-cover border"
                                                    style="object-fit: cover;">
                                            @else
                                                <img src="{{ asset('img/foto-tidak-ada.png') }}" alt="No Avatar"
                                                    width="50" height="50"
                                                    class="rounded-lg object-fit-cover border"
                                                    style="object-fit: cover;">
                                            @endif
                                        </td>

                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->jabatan->nama ?? '-' }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->jenis_kelamin }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $item->no_telepon }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
