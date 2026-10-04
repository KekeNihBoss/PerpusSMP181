<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Principal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'message',
        'photo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Accessor untuk URL foto
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }
}