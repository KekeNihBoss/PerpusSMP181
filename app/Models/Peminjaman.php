<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'idbuku',
        'namabuku',
        'tanggal_pinjam',
        'tanggal_tenggat',
        'status',
    ];

    // Otomatis isi tanggal_tenggat dan status saat membuat peminjaman baru
protected static function booted()
{
    static::creating(function ($peminjaman) {
        // Kalau belum ada tanggal pinjam, isi tanggal hari ini
        if (empty($peminjaman->tanggal_pinjam)) {
            $peminjaman->tanggal_pinjam = now();
        }

        // Set tenggat otomatis 7 hari dari tanggal pinjam
        $peminjaman->tanggal_tenggat = Carbon::parse($peminjaman->tanggal_pinjam)->addDays(7);

        // Status default
        $peminjaman->status = 'Dipinjam';

        // ⭐ TAMBAHKAN INI: Kurangi stok buku
        $buku = DataBuku::where('idbuku', $peminjaman->idbuku)->first();
        if ($buku && $buku->stokbuku > 0) {
            $buku->decrement('stokbuku');
        }
    });
}

    // Accessor: otomatis ubah status jadi "Terlambat" kalau lewat tenggat
    public function getStatusAttribute($value)
    {
        if ($value === 'Dipinjam' && now()->greaterThan(Carbon::parse($this->tanggal_tenggat))) {
            return 'Terlambat';
        }

        return $value;
    }

    public function Siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'nis');
    }

    public function Buku()
    {
        return $this->belongsTo(DataBuku::class, 'buku_id');
    }
}
