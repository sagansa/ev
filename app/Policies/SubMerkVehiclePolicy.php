<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SubMerkVehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubMerkVehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subMerkVehicle can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the subMerkVehicle can view the model.
     */
    public function view(User $user, SubMerkVehicle $model): bool
    {
        return true;
    }

    /**
     * Determine whether the subMerkVehicle can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the subMerkVehicle can update the model.
     */
    public function update(User $user, SubMerkVehicle $model): bool
    {
        return true;
    }

    /**
     * Determine whether the subMerkVehicle can delete the model.
     */
    public function delete(User $user, SubMerkVehicle $model): bool
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
     * Determine whether the subMerkVehicle can restore the model.
     */
    public function restore(User $user, SubMerkVehicle $model): bool
    {
        return false;
    }

    /**
     * Determine whether the subMerkVehicle can permanently delete the model.
     */
    public function forceDelete(User $user, SubMerkVehicle $model): bool
    {
        return false;
    }
}
