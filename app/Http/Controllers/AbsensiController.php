<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // untuk export Excel
use PDF; // untuk export PDF (pastikan sudah install barryvdh/laravel-dompdf)

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filter: kelas, tanggal, search
        $query = Absensi::query();
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%");
            });
        }
        $absensi = $query->with(['siswa.rombel.kelas'])->orderBy('tanggal', 'desc')->get();
        return view('absensi.index', compact('absensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan form tambah absensi
        return view('absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable',
        ]);
        Absensi::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        return view('absensi.show', compact('absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        return view('absensi.edit', compact('absensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable',
        ]);
        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus.');
    }

    /**
     * Export the resource to the specified type.
     */
    public function export($type)
    {
        $absensi = \App\Models\Absensi::with(['rombel.kelas'])->orderBy('tanggal', 'desc')->get();

        if ($type === 'excel') {
            // Export Excel
            return Excel::download(new \App\Exports\AbsensiExport($absensi), 'absensi.xlsx');
        } elseif ($type === 'pdf') {
            // Export PDF
            $pdf = PDF::loadView('absensi.export_pdf', compact('absensi'));
            return $pdf->download('absensi.pdf');
        }
        return back();
    }
}
