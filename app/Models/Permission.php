<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // agar accessor 'label' selalu tersedia ketika dipakai di view
    protected $appends = ['label'];

    public function getLabelAttribute(): string
    {
        $name = $this->attributes['name'];

        // bersihkan prefix seperti 'data::' (dari Shield) agar lebih readable
        $clean = str_replace('data::', '', $name);

        // action detect
        if (preg_match('/^(view_any|view)_?(.*)$/i', $clean, $m)) {
            $action = 'Lihat';
            $resource = $m[2];
            if (str_starts_with($m[1], 'view_any')) {
                $action = 'Lihat Semua';
            }
        } elseif (preg_match('/^create_?(.*)$/i', $clean, $m)) {
            $action = 'Tambah';
            $resource = $m[1];
        } elseif (preg_match('/^update_?(.*)$/i', $clean, $m)) {
            $action = 'Edit';
            $resource = $m[1];
        } elseif (preg_match('/^delete_?(.*)$/i', $clean, $m)) {
            $action = 'Hapus';
            $resource = $m[1];
        } else {
            // fallback: pisah underscore jadi spasi
            $parts = explode('_', $clean);
            $action = ucfirst(array_shift($parts));
            $resource = implode(' ', $parts);
        }

        // rapiin resource (ubah underscore jadi spasi, hapus kata kosong)
        $resource = trim(str_replace('_', ' ', $resource));
        $resource = ucwords($resource);

        return trim(sprintf('%s %s', $action, $resource));
    }
}
