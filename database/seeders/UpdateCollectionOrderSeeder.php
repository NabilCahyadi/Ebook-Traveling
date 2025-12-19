<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;

class UpdateCollectionOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = Collection::all();

        foreach ($collections as $index => $collection) {
            $collection->update([
                'order' => $index,
                // 'is_visible_on_landing' => true
            ]);
        }

        $this->command->info("Updated {$collections->count()} collections with order numbers.");
    }
}
