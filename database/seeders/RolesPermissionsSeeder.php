<?php

namespace Database\Seeders;

use App\Enums\RoleNames;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $access = config('permission.access');

        foreach ($access as $type) {
            foreach ($type as $permission) {
                Permission::findOrCreate($permission);
            }
        }

        // Customer
        if (!Role::where('name', RoleNames::CUSTOMER->value)->exists()) {
            $role = Role::create(['name' => RoleNames::CUSTOMER->value]);
            $role->givePermissionTo(array_values($access['account']));
        }

        if ( !Role::where('name', RoleNames::MANAGER->value)->exists()) {
            $moderatorRoles = array_merge(
                array_values($access['categories']),
                array_values($access['products'])
            );
            $role = Role::create(['name' => RoleNames::MANAGER->value])
                ->givePermissionTo($moderatorRoles);
        }
        if ( !Role::where('name', RoleNames::ADMIN->value)->exists()) {
            $role = Role::create(['name' => RoleNames::ADMIN->value]);
            $role->givePermissionTo(Permission::all());
        }
    }
}
