<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $blogCategories = [
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Travel & Nature',
                'slug' => 'travel-nature',
                'description' => 'Explore destinations, travel tips, and natural wonders',
                'type' => 'blog',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Food & Culture',
                'slug' => 'food-culture',
                'description' => 'Discover culinary delights and cultural experiences',
                'type' => 'blog',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Tips & Trick',
                'slug' => 'tips-trick',
                'description' => 'Helpful tips and tricks for travelers',
                'type' => 'blog',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Culture & History',
                'slug' => 'culture-history',
                'description' => 'Learn about local culture and historical sites',
                'type' => 'blog',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($blogCategories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')
            ->where('type', 'blog')
            ->whereIn('slug', ['travel-nature', 'food-culture', 'tips-trick', 'culture-history'])
            ->delete();
    }
};
