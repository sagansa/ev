<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TypeVehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypeVehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the typeVehicle can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the typeVehicle can view the model.
     */
    public function view(User $user, TypeVehicle $model): bool
    {
        return true;
    }

    /**
     * Determine whether the typeVehicle can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the typeVehicle can update the model.
     */
    public function update(User $user, TypeVehicle $model): bool
    {
        return true;
    }

    /**
     * Determine whether the typeVehicle can delete the model.
     */
    public function delete(User $user, TypeVehicle $model): bool
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
     * Determine whether the typeVehicle can restore the model.
     */
    public function restore(User $user, TypeVehicle $model): bool
    {
        return false;
    }

    /**
     * Determine whether the typeVehicle can permanently delete the model.
     */
    public function forceDelete(User $user, TypeVehicle $model): bool
    {
        return false;
    }
}
