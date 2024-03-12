<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Charge;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the charge can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list charges');
    }

    /**
     * Determine whether the charge can view the model.
     */
    public function view(User $user, Charge $model): bool
    {
        return $user->hasPermissionTo('view charges');
    }

    /**
     * Determine whether the charge can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create charges');
    }

    /**
     * Determine whether the charge can update the model.
     */
    public function update(User $user, Charge $model): bool
    {
        return $user->hasPermissionTo('update charges');
    }

    /**
     * Determine whether the charge can delete the model.
     */
    public function delete(User $user, Charge $model): bool
    {
        return $user->hasPermissionTo('delete charges');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete charges');
    }

    /**
     * Determine whether the charge can restore the model.
     */
    public function restore(User $user, Charge $model): bool
    {
        return false;
    }

    /**
     * Determine whether the charge can permanently delete the model.
     */
    public function forceDelete(User $user, Charge $model): bool
    {
        return false;
    }
}
