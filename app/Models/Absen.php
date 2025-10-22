<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis', 'nama', 'kelas', 'jenis_kelamin','tanggal',
    ];
        // Relasi ke DataSiswa
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'nis', 'nis');
    }
}
