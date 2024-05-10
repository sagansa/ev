<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Charger;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the charger can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the charger can view the model.
     */
    public function view(User $user, Charger $model): bool
    {
        return true;
    }

    /**
     * Determine whether the charger can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the charger can update the model.
     */
    public function update(User $user, Charger $model): bool
    {
        return true;
    }

    /**
     * Determine whether the charger can delete the model.
     */
    public function delete(User $user, Charger $model): bool
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
     * Determine whether the charger can restore the model.
     */
    public function restore(User $user, Charger $model): bool
    {
        return false;
    }

    /**
     * Determine whether the charger can permanently delete the model.
     */
    public function forceDelete(User $user, Charger $model): bool
    {
        return false;
    }
}
