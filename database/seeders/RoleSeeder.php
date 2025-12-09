<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator with full access',
                'is_active' => true,
            ],
            [
                'name' => 'Creator',
                'slug' => 'creator',
                'description' => 'Content creator can manage their own content',
                'is_active' => true,
            ],
            [
                'name' => 'Member',
                'slug' => 'member',
                'description' => 'Regular member user',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
