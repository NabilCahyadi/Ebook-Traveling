<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Category;

class UpdateBlogCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping old category names to new ones
        $categoryMapping = [
            'Travel & Adventure' => 'Travel & Nature',
            'Travel' => 'Travel & Nature',
            'Culture & Art' => 'Culture & History',
            'Culture' => 'Culture & History',
            'Food & Culture' => 'Food & Culture',
            'Tips & Trick' => 'Tips & Trick',
            'Tips' => 'Tips & Trick',
        ];

        foreach ($categoryMapping as $oldName => $newName) {
            $category = Category::where('type', 'blog')->where('name', $newName)->first();
            
            if ($category) {
                $updated = Blog::where('category', $oldName)->update(['category' => $category->name]);
                
                if ($updated > 0) {
                    $this->command->info("Updated {$updated} blog(s) from '{$oldName}' to '{$newName}'");
                }
            }
        }

        $this->command->info('Blog categories updated successfully!');
    }
}
