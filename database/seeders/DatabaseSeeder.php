<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CityCategorySeeder::class,
            CollectionSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            CitySeeder::class,
            EbookSeeder::class,
            BannerSeeder::class,
            EbookCategorySeeder::class,
            CollectionEbookSeeder::class,
            SubscriptionPlanSeeder::class,
            SubscriptionSeeder::class,
            BlogSeeder::class,
            PremiumUserSeeder::class,
        ]);
    }
}
