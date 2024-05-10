<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Provider;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the provider can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the provider can view the model.
     */
    public function view(User $user, Provider $model): bool
    {
        return true;
    }

    /**
     * Determine whether the provider can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the provider can update the model.
     */
    public function update(User $user, Provider $model): bool
    {
        return true;
    }

    /**
     * Determine whether the provider can delete the model.
     */
    public function delete(User $user, Provider $model): bool
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
     * Determine whether the provider can restore the model.
     */
    public function restore(User $user, Provider $model): bool
    {
        return false;
    }

    /**
     * Determine whether the provider can permanently delete the model.
     */
    public function forceDelete(User $user, Provider $model): bool
    {
        return false;
    }
}
