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
        // FAQ Categories to add
        $categories = [
            'subscription' => 'Subscription & Membership',
            'payment' => 'Payments & Transactions',
            'ebook-access' => 'eBook Access & Reading',
            'support' => 'Account & Technical Support',
            'content' => 'Content & Features'
        ];

        foreach ($categories as $slug => $name) {
            $permissions = [
                [
                    'name' => "website.faqs-{$slug}.view",
                    'display_name' => "View FAQ {$name}",
                    'description' => "Can view FAQ {$name} list",
                    'module' => 'Website Management',
                    'sub_module' => 'FAQ'
                ],
                [
                    'name' => "website.faqs-{$slug}.create",
                    'display_name' => "Create FAQ {$name}",
                    'description' => "Can create new FAQ {$name}",
                    'module' => 'Website Management',
                    'sub_module' => 'FAQ'
                ],
                [
                    'name' => "website.faqs-{$slug}.edit",
                    'display_name' => "Edit FAQ {$name}",
                    'description' => "Can edit FAQ {$name}",
                    'module' => 'Website Management',
                    'sub_module' => 'FAQ'
                ],
                [
                    'name' => "website.faqs-{$slug}.delete",
                    'display_name' => "Delete FAQ {$name}",
                    'description' => "Can delete FAQ {$name}",
                    'module' => 'Website Management',
                    'sub_module' => 'FAQ'
                ]
            ];

            foreach ($permissions as $permission) {
                AdminPermission::firstOrCreate(
                    ['name' => $permission['name']],
                    [
                        'display_name' => $permission['display_name'],
                        'description' => $permission['description'],
                        'module' => $permission['module'],
                        'sub_module' => $permission['sub_module']
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $categories = ['subscription', 'payment', 'ebook-access', 'support', 'content'];
        
        foreach ($categories as $slug) {
            AdminPermission::whereIn('name', [
                "website.faqs-{$slug}.view",
                "website.faqs-{$slug}.create",
                "website.faqs-{$slug}.edit",
                "website.faqs-{$slug}.delete"
            ])->delete();
        }
    }
};
