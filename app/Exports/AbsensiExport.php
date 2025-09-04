<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    protected $absensi;
    public function __construct($absensi)
    {
        $this->absensi = $absensi;
    }
    public function view(): View
    {
        return view('absensi.export_excel', [
            'absensi' => $this->absensi
        ]);
    }
}