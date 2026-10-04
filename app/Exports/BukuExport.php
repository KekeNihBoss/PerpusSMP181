<?php

namespace App\Exports;

use App\Models\DataBuku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DataBuku::select('idbuku', 'judul', 'kategori', 'stokbuku', 'nomorrak', 'penerbit', 'penulis', 'tahunpembelian')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Buku',
            'Kategori',
            'Stok Buku',
            'Nomor Rak',
            'Penulis',
            'Penerbit',
            'Tahun Pembelian',
        ];
    }
}
