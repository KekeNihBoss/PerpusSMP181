<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis', 'nama', 'kelas', 'jenis_kelamin','email', 'tlp', 'alamat', 'foto'
    ];
    public function siswa()
    {
        // localKey di model ini = 'nis', ownerKey di DataSiswa = 'nis'
        return $this->belongsTo(DataSiswa::class, 'nis', 'nis');
    }
}
