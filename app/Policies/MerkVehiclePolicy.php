<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MerkVehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class MerkVehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the merkVehicle can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the merkVehicle can view the model.
     */
    public function view(User $user, MerkVehicle $model): bool
    {
        return true;
    }

    /**
     * Determine whether the merkVehicle can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the merkVehicle can update the model.
     */
    public function update(User $user, MerkVehicle $model): bool
    {
        return true;
    }

    /**
     * Determine whether the merkVehicle can delete the model.
     */
    public function delete(User $user, MerkVehicle $model): bool
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
     * Determine whether the merkVehicle can restore the model.
     */
    public function restore(User $user, MerkVehicle $model): bool
    {
        return false;
    }

    /**
     * Determine whether the merkVehicle can permanently delete the model.
     */
    public function forceDelete(User $user, MerkVehicle $model): bool
    {
        return false;
    }
}
