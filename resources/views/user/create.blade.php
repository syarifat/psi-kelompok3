@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Tambah User</h2>
    <form action="{{ route('user.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required value="{{ old('name') }}">
            @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required value="{{ old('email') }}">
            @error('email')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            @error('password')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Role</label>
            <select name="role" id="role" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pemilik_kantin" {{ old('role') == 'pemilik_kantin' ? 'selected' : '' }}>Pemilik Kantin</option>
            </select>
            @error('role')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Dropdown Kantin muncul hanya jika role = pemilik_kantin --}}
        <div class="mb-4" id="kantin-container" style="display: none;">
            <label class="block mb-1 font-semibold">Pilih Kantin</label>
            <select name="kantin_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih Kantin --</option>
                @foreach($kantin as $k)
                    <option value="{{ $k->kantin_id }}" {{ old('kantin_id') == $k->kantin_id ? 'selected' : '' }}>
                        {{ $k->nama_kantin }}
                    </option>
                @endforeach
            </select>
            @error('kantin_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const roleSelect = document.getElementById("role");
                const kantinContainer = document.getElementById("kantin-container");

                function toggleKantin() {
                    if (roleSelect.value === "pemilik_kantin") {
                        kantinContainer.style.display = "block";
                    } else {
                        kantinContainer.style.display = "none";
                    }
                }

                roleSelect.addEventListener("change", toggleKantin);
                toggleKantin(); // cek default (old value)
            });
        </script>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold shadow">Simpan</button>
        </div>
    </form>
</div>
@endsection
