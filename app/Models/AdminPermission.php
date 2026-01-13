<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'sub_module',
        'group',
    ];

    /**
     * Get the admins that have this permission.
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_permission', 'admin_permission_id', 'admin_id');
    }
}
