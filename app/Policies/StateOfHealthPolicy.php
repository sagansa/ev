<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StateOfHealth;
use Illuminate\Auth\Access\HandlesAuthorization;

class StateOfHealthPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the stateOfHealth can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the stateOfHealth can view the model.
     */
    public function view(User $user, StateOfHealth $model): bool
    {
        return true;
    }

    /**
     * Determine whether the stateOfHealth can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the stateOfHealth can update the model.
     */
    public function update(User $user, StateOfHealth $model): bool
    {
        return true;
    }

    /**
     * Determine whether the stateOfHealth can delete the model.
     */
    public function delete(User $user, StateOfHealth $model): bool
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
     * Determine whether the stateOfHealth can restore the model.
     */
    public function restore(User $user, StateOfHealth $model): bool
    {
        return false;
    }

    /**
     * Determine whether the stateOfHealth can permanently delete the model.
     */
    public function forceDelete(User $user, StateOfHealth $model): bool
    {
        return false;
    }
}
