<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TemplateController extends Controller
{
    public function buku(): BinaryFileResponse
    {
        return Excel::download(
            new TemplateExport(['idbuku', 'judul', 'kategori', 'stokbuku', 'nomorrak', 'penerbit', 'penulis', 'tahunpembelian']),
            'template-import-buku.xlsx'
        );
    }

    public function siswa(): BinaryFileResponse
    {
        return Excel::download(
            new TemplateExport(['nis', 'nama', 'kelas', 'jenis_kelamin', 'email', 'tlp', 'alamat', 'foto']),
            'template-import-siswa.xlsx'
        );
    }
}
