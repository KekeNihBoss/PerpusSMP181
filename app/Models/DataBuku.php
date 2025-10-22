<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataBuku extends Model
{
    use HasFactory;
    protected $table = 'data_bukus';
    protected $fillable = [
        'idbuku', 'judul', 'kategori','stokbuku', 'nomorrak', 'penerbit', 'penulis', 'tahunpembelian'
    ];
}
