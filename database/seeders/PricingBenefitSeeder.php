<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PricingBenefit;

class PricingBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefits = [
            [
                'icon' => 'bi bi-globe-americas',
                'title' => 'Unlimited Guides, Anywhere',
                'description' => 'Get instant access to our entire library of verified guides, from major cities to hidden gems.',
                'sort_order' => 1,
            ],
            [
                'icon' => 'bi bi-file-earmark-arrow-down',
                'title' => 'Explore Offline, Stress-Free',
                'description' => 'Download your guides once and access them anytime, anywhere, even without Wi-Fi or data roaming.',
                'sort_order' => 2,
            ],
            [
                'icon' => 'bi bi-geo',
                'title' => 'Insider Tips & Secret Spots',
                'description' => 'Access hand-picked recommendations from local experts and discover truly exclusive destinations.',
                'sort_order' => 3,
            ],
            [
                'icon' => 'bi bi-card-checklist',
                'title' => 'Effortless Planning Tools',
                'description' => 'Utilize interactive checklists and organized tools for a smooth, stress-free pre-trip planning experience.',
                'sort_order' => 4,
            ],
            [
                'icon' => 'bi bi-arrow-repeat',
                'title' => 'Always Up-to-Date Routes',
                'description' => 'Enjoy seamless routine updates with the newest routes, local tips, and latest travel regulations.',
                'sort_order' => 5,
            ],
        ];

        foreach ($benefits as $benefit) {
            PricingBenefit::create($benefit);
        }
    }
}
