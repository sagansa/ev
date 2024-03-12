<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChargerType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargerTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the chargerType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list chargertypes');
    }

    /**
     * Determine whether the chargerType can view the model.
     */
    public function view(User $user, ChargerType $model): bool
    {
        return $user->hasPermissionTo('view chargertypes');
    }

    /**
     * Determine whether the chargerType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create chargertypes');
    }

    /**
     * Determine whether the chargerType can update the model.
     */
    public function update(User $user, ChargerType $model): bool
    {
        return $user->hasPermissionTo('update chargertypes');
    }

    /**
     * Determine whether the chargerType can delete the model.
     */
    public function delete(User $user, ChargerType $model): bool
    {
        return $user->hasPermissionTo('delete chargertypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete chargertypes');
    }

    /**
     * Determine whether the chargerType can restore the model.
     */
    public function restore(User $user, ChargerType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the chargerType can permanently delete the model.
     */
    public function forceDelete(User $user, ChargerType $model): bool
    {
        return false;
    }
}
