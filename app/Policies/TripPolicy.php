<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the trip can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the trip can view the model.
     */
    public function view(User $user, Trip $model): bool
    {
        return true;
    }

    /**
     * Determine whether the trip can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the trip can update the model.
     */
    public function update(User $user, Trip $model): bool
    {
        return true;
    }

    /**
     * Determine whether the trip can delete the model.
     */
    public function delete(User $user, Trip $model): bool
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
     * Determine whether the trip can restore the model.
     */
    public function restore(User $user, Trip $model): bool
    {
        return false;
    }

    /**
     * Determine whether the trip can permanently delete the model.
     */
    public function forceDelete(User $user, Trip $model): bool
    {
        return false;
    }
}
