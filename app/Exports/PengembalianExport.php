<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengembalianExport implements FromCollection, WithHeadings
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
        $query = Pengembalian::query();

        if ($this->bulan && $this->tahun) {
            $query->whereMonth('tanggal_kembali', $this->bulan)
                  ->whereYear('tanggal_kembali', $this->tahun);
        } elseif ($this->tahun) {
            $query->whereYear('tanggal_kembali', $this->tahun);
        }

        return $query->get([
            'nis',
            'nama',
            'kelas',
            'idbuku',
            'namabuku',
            'tanggal_pinjam',
            'tanggal_kembali',
        ]);
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Kelas',
            'ID Buku',
            'Nama Buku',
            'Tanggal Pinjam',
            'Tanggal Kembali',
        ];
    }
}
