<?php

namespace Database\Seeders\Production\Core;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PanelAccessPermissionSeeder extends Seeder
{
    /**
     * Seed panel access permission.
     */
    public function run(): void
    {
        // Permission untuk mengakses panel
        Permission::updateOrCreate(
            ['name' => 'panel.access'],
            [
                'display_name' => 'Access Management Panel',
                'description' => 'Can login and access management panel',
                'group' => 'Panel Access',
                'module' => 'panel'
            ]
        );

        $this->command->info('Panel access permission created!');
        
        // Auto assign ke role admin dan creator
        $adminRole = \App\Models\Role::where('slug', 'admin')->first();
        $creatorRole = \App\Models\Role::where('slug', 'creator')->first();
        
        $permission = Permission::where('name', 'panel.access')->first();
        
        if ($adminRole && $permission) {
            $adminRole->permissions()->syncWithoutDetaching([$permission->id]);
            $this->command->info('Panel access granted to Admin role');
        }
        
        if ($creatorRole && $permission) {
            $creatorRole->permissions()->syncWithoutDetaching([$permission->id]);
            $this->command->info('Panel access granted to Creator role');
        }
    }
}
