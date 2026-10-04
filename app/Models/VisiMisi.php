<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VisiMisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'pdf_file',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor untuk URL PDF
    public function getPdfUrlAttribute()
    {
        return $this->pdf_file ? Storage::url($this->pdf_file) : null;
    }
    
}