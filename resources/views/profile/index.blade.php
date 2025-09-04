@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">Informasi Profile</h2>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <span class="font-semibold">Nama:</span>
            <span>{{ Auth::user()->name }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Email:</span>
            <span>{{ Auth::user()->email }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Role:</span>
            <span>{{ Auth::user()->role }}</span>
        </div>
        <!-- Tambahkan info lain sesuai kebutuhan -->
        <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</a>
    </div>
</div>
@endsection