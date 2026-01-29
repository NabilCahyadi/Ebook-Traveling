<?php

namespace Database\Seeders\Production\Core;

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
                'name' => 'Reader',
                'slug' => 'reader',
                'description' => 'Regular reader who can read and interact with ebooks',
                'is_active' => true,
            ],
            [
                'name' => 'Creator',
                'slug' => 'creator',
                'description' => 'Content creator who can create and manage ebooks',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }

        $this->command->info('✅ Roles seeded successfully');
        $this->command->info('   - Reader: Regular users who can read ebooks');
        $this->command->info('   - Creator: Users who can create and manage ebooks');
    }
}
