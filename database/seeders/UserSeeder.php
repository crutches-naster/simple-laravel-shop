<?php

namespace Database\Seeders;

use App\Enums\RoleNames;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const ADMIN_EMAIL = 'admin@admin.com';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', self::ADMIN_EMAIL)->exists()) {
            $admin = User::factory()->withEmail(self::ADMIN_EMAIL)->create();
            $admin->syncRoles(RoleNames::ADMIN->value);
        }
        User::factory(10)->create();
    }
}

