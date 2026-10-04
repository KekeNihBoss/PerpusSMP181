<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis', 'nama', 'kelas', 'idbuku', 'namabuku', 'tanggal_pinjam', 'tanggal_kembali',
    ];
        public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'nis', 'nis');
    }
}
