<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FuelOilCost;
use Illuminate\Auth\Access\HandlesAuthorization;

class FuelOilCostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fuelOilCost can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list fueloilcosts');
    }

    /**
     * Determine whether the fuelOilCost can view the model.
     */
    public function view(User $user, FuelOilCost $model): bool
    {
        return $user->hasPermissionTo('view fueloilcosts');
    }

    /**
     * Determine whether the fuelOilCost can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create fueloilcosts');
    }

    /**
     * Determine whether the fuelOilCost can update the model.
     */
    public function update(User $user, FuelOilCost $model): bool
    {
        return $user->hasPermissionTo('update fueloilcosts');
    }

    /**
     * Determine whether the fuelOilCost can delete the model.
     */
    public function delete(User $user, FuelOilCost $model): bool
    {
        return $user->hasPermissionTo('delete fueloilcosts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete fueloilcosts');
    }

    /**
     * Determine whether the fuelOilCost can restore the model.
     */
    public function restore(User $user, FuelOilCost $model): bool
    {
        return false;
    }

    /**
     * Determine whether the fuelOilCost can permanently delete the model.
     */
    public function forceDelete(User $user, FuelOilCost $model): bool
    {
        return false;
    }
}
