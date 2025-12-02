<?php

namespace App\View\Composers;

use App\Models\Role;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $roles = Role::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $view->with('sidebarRoles', $roles);
    }
}
