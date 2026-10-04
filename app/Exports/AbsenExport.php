<?php

namespace App\Exports;

use App\Models\Absen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Request;

class AbsenExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Absen::query();

        // Filter berdasarkan bulan & tahun kalau ada
        if ($this->bulan && $this->tahun) {
            $query->whereMonth('tanggal', $this->bulan)
                  ->whereYear('tanggal', $this->tahun);
        }

        // Ambil hanya field tertentu
        return $query->select('nama', 'kelas', 'tanggal')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Kelas',
            'Tanggal Kehadiran',
        ];
    }
}
