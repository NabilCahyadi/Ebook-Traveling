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
        // Exclude 'guest' role because guest users are not stored in database (anonymous users)
        $roles = Role::where('is_active', true)
            ->where('slug', '!=', 'guest')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $view->with('sidebarRoles', $roles);
    }
}
