<?php

namespace App\Imports;

use App\Models\DataBuku;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataBukuImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataBuku([
            'idbuku'   => $row['idbuku'],   // pastikan header di Excel sama
            'judul'    => $row['judul'],
            'kategori' => $row['kategori'],
            'stokbuku' => $row['stokbuku'],
            'nomorrak' => $row['nomorrak'],
            'penerbit' => $row['penerbit'],
            'penulis'  => $row['penulis'],
            'tahunpembelian' => $row['tahunpembelian']
        ]);
    }
}
