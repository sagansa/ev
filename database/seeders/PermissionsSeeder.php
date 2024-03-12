<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list charges']);
        Permission::create(['name' => 'view charges']);
        Permission::create(['name' => 'create charges']);
        Permission::create(['name' => 'update charges']);
        Permission::create(['name' => 'delete charges']);

        Permission::create(['name' => 'list chargers']);
        Permission::create(['name' => 'view chargers']);
        Permission::create(['name' => 'create chargers']);
        Permission::create(['name' => 'update chargers']);
        Permission::create(['name' => 'delete chargers']);

        Permission::create(['name' => 'list chargerlocations']);
        Permission::create(['name' => 'view chargerlocations']);
        Permission::create(['name' => 'create chargerlocations']);
        Permission::create(['name' => 'update chargerlocations']);
        Permission::create(['name' => 'delete chargerlocations']);

        Permission::create(['name' => 'list chargertypes']);
        Permission::create(['name' => 'view chargertypes']);
        Permission::create(['name' => 'create chargertypes']);
        Permission::create(['name' => 'update chargertypes']);
        Permission::create(['name' => 'delete chargertypes']);

        Permission::create(['name' => 'list cities']);
        Permission::create(['name' => 'view cities']);
        Permission::create(['name' => 'create cities']);
        Permission::create(['name' => 'update cities']);
        Permission::create(['name' => 'delete cities']);

        Permission::create(['name' => 'list detailtrips']);
        Permission::create(['name' => 'view detailtrips']);
        Permission::create(['name' => 'create detailtrips']);
        Permission::create(['name' => 'update detailtrips']);
        Permission::create(['name' => 'delete detailtrips']);

        Permission::create(['name' => 'list electriccurrents']);
        Permission::create(['name' => 'view electriccurrents']);
        Permission::create(['name' => 'create electriccurrents']);
        Permission::create(['name' => 'update electriccurrents']);
        Permission::create(['name' => 'delete electriccurrents']);

        Permission::create(['name' => 'list fueloilcosts']);
        Permission::create(['name' => 'view fueloilcosts']);
        Permission::create(['name' => 'create fueloilcosts']);
        Permission::create(['name' => 'update fueloilcosts']);
        Permission::create(['name' => 'delete fueloilcosts']);

        Permission::create(['name' => 'list merkvehicles']);
        Permission::create(['name' => 'view merkvehicles']);
        Permission::create(['name' => 'create merkvehicles']);
        Permission::create(['name' => 'update merkvehicles']);
        Permission::create(['name' => 'delete merkvehicles']);

        Permission::create(['name' => 'list providers']);
        Permission::create(['name' => 'view providers']);
        Permission::create(['name' => 'create providers']);
        Permission::create(['name' => 'update providers']);
        Permission::create(['name' => 'delete providers']);

        Permission::create(['name' => 'list provinces']);
        Permission::create(['name' => 'view provinces']);
        Permission::create(['name' => 'create provinces']);
        Permission::create(['name' => 'update provinces']);
        Permission::create(['name' => 'delete provinces']);

        Permission::create(['name' => 'list stateofhealths']);
        Permission::create(['name' => 'view stateofhealths']);
        Permission::create(['name' => 'create stateofhealths']);
        Permission::create(['name' => 'update stateofhealths']);
        Permission::create(['name' => 'delete stateofhealths']);

        Permission::create(['name' => 'list submerkvehicles']);
        Permission::create(['name' => 'view submerkvehicles']);
        Permission::create(['name' => 'create submerkvehicles']);
        Permission::create(['name' => 'update submerkvehicles']);
        Permission::create(['name' => 'delete submerkvehicles']);

        Permission::create(['name' => 'list trips']);
        Permission::create(['name' => 'view trips']);
        Permission::create(['name' => 'create trips']);
        Permission::create(['name' => 'update trips']);
        Permission::create(['name' => 'delete trips']);

        Permission::create(['name' => 'list typevehicles']);
        Permission::create(['name' => 'view typevehicles']);
        Permission::create(['name' => 'create typevehicles']);
        Permission::create(['name' => 'update typevehicles']);
        Permission::create(['name' => 'delete typevehicles']);

        Permission::create(['name' => 'list vehicles']);
        Permission::create(['name' => 'view vehicles']);
        Permission::create(['name' => 'create vehicles']);
        Permission::create(['name' => 'update vehicles']);
        Permission::create(['name' => 'delete vehicles']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
