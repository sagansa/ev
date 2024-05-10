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
        return true;
    }

    /**
     * Determine whether the charge can view the model.
     */
    public function view(User $user, Charge $model): bool
    {
        return true;
    }

    /**
     * Determine whether the charge can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the charge can update the model.
     */
    public function update(User $user, Charge $model): bool
    {
        return true;
    }

    /**
     * Determine whether the charge can delete the model.
     */
    public function delete(User $user, Charge $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
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
