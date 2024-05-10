<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ElectricCurrent;
use Illuminate\Auth\Access\HandlesAuthorization;

class ElectricCurrentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the electricCurrent can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the electricCurrent can view the model.
     */
    public function view(User $user, ElectricCurrent $model): bool
    {
        return true;
    }

    /**
     * Determine whether the electricCurrent can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the electricCurrent can update the model.
     */
    public function update(User $user, ElectricCurrent $model): bool
    {
        return true;
    }

    /**
     * Determine whether the electricCurrent can delete the model.
     */
    public function delete(User $user, ElectricCurrent $model): bool
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
     * Determine whether the electricCurrent can restore the model.
     */
    public function restore(User $user, ElectricCurrent $model): bool
    {
        return false;
    }

    /**
     * Determine whether the electricCurrent can permanently delete the model.
     */
    public function forceDelete(User $user, ElectricCurrent $model): bool
    {
        return false;
    }
}
