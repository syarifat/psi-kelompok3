@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Data Kantin</h1>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Nama Kantin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kantins as $kantin)
            <tr>
                <td class="px-4 py-2 border">{{ $kantin->nama_kantin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
