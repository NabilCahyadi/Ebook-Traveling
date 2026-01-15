<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AdminPermission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create FAQ Pricing permissions
        $permissions = [
            [
                'name' => 'website.faqs-pricing.view',
                'display_name' => 'View FAQ Pricing',
                'description' => 'Can view FAQ pricing list'
            ],
            [
                'name' => 'website.faqs-pricing.create',
                'display_name' => 'Create FAQ Pricing',
                'description' => 'Can create new FAQ pricing'
            ],
            [
                'name' => 'website.faqs-pricing.edit',
                'display_name' => 'Edit FAQ Pricing',
                'description' => 'Can edit FAQ pricing'
            ],
            [
                'name' => 'website.faqs-pricing.delete',
                'display_name' => 'Delete FAQ Pricing',
                'description' => 'Can delete FAQ pricing'
            ]
        ];

        foreach ($permissions as $permission) {
            AdminPermission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description']
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove FAQ Pricing permissions
        AdminPermission::whereIn('name', [
            'website.faqs-pricing.view',
            'website.faqs-pricing.create',
            'website.faqs-pricing.edit',
            'website.faqs-pricing.delete'
        ])->delete();
    }
};
