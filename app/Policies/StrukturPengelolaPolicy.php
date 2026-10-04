<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StrukturPengelola;
use Illuminate\Auth\Access\HandlesAuthorization;

class StrukturPengelolaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_struktur::pengelola');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StrukturPengelola $strukturPengelola): bool
    {
        return $user->can('view_struktur::pengelola');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_struktur::pengelola');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StrukturPengelola $strukturPengelola): bool
    {
        return $user->can('update_struktur::pengelola');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StrukturPengelola $strukturPengelola): bool
    {
        return $user->can('delete_struktur::pengelola');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_struktur::pengelola');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, StrukturPengelola $strukturPengelola): bool
    {
        return $user->can('force_delete_struktur::pengelola');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_struktur::pengelola');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, StrukturPengelola $strukturPengelola): bool
    {
        return $user->can('restore_struktur::pengelola');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_struktur::pengelola');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, StrukturPengelola $strukturPengelola): bool
    {
        return $user->can('replicate_struktur::pengelola');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_struktur::pengelola');
    }
}
