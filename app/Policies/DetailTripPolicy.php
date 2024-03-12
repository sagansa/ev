<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DetailTrip;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailTripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the detailTrip can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list detailtrips');
    }

    /**
     * Determine whether the detailTrip can view the model.
     */
    public function view(User $user, DetailTrip $model): bool
    {
        return $user->hasPermissionTo('view detailtrips');
    }

    /**
     * Determine whether the detailTrip can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create detailtrips');
    }

    /**
     * Determine whether the detailTrip can update the model.
     */
    public function update(User $user, DetailTrip $model): bool
    {
        return $user->hasPermissionTo('update detailtrips');
    }

    /**
     * Determine whether the detailTrip can delete the model.
     */
    public function delete(User $user, DetailTrip $model): bool
    {
        return $user->hasPermissionTo('delete detailtrips');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete detailtrips');
    }

    /**
     * Determine whether the detailTrip can restore the model.
     */
    public function restore(User $user, DetailTrip $model): bool
    {
        return false;
    }

    /**
     * Determine whether the detailTrip can permanently delete the model.
     */
    public function forceDelete(User $user, DetailTrip $model): bool
    {
        return false;
    }
}
