<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChargerLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargerLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the chargerLocation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the chargerLocation can view the model.
     */
    public function view(User $user, ChargerLocation $model): bool
    {
        return true;
    }

    /**
     * Determine whether the chargerLocation can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the chargerLocation can update the model.
     */
    public function update(User $user, ChargerLocation $model): bool
    {
        return true;
    }

    /**
     * Determine whether the chargerLocation can delete the model.
     */
    public function delete(User $user, ChargerLocation $model): bool
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
     * Determine whether the chargerLocation can restore the model.
     */
    public function restore(User $user, ChargerLocation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the chargerLocation can permanently delete the model.
     */
    public function forceDelete(User $user, ChargerLocation $model): bool
    {
        return false;
    }
}
