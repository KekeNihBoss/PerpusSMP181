<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BookRecommendation extends Model
{
    protected $fillable = [
        'title', 'author', 'description', 'cover', 'category', 'year', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->latest();
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover ? Storage::url($this->cover) : null;
    }
}