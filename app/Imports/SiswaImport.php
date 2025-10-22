<?php

namespace App\Imports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataSiswa([
            'nis'           => $row['nis'],
            'nama'          => $row['nama'],
            'kelas'         => $row['kelas'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tlp'           => $row['tlp'],
            'alamat'        => $row['alamat'],
            'foto'          => $row['foto'], // sementara cuma simpan nama file / URL
        ]);
    }
}
