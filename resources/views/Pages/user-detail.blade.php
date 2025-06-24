@extends('layouts.dashboard')
@section('content')
    <div class="card p-4">
        <h4 class="mb-4">Detail User</h4>
        <ul class="list-group">
            <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
            <li class="list-group-item"><strong>Password:</strong> {{ $user->password }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ $user->status }}</li>
            <li class="list-group-item"><strong>Role:</strong> {{ $user->role->nama ?? '-' }}</li>
            <li class="list-group-item"><strong>NIK:</strong> {{ $user->nik }}</li>
        </ul>
        <a href="{{ route('user') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
