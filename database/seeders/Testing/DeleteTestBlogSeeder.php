<?php

namespace Database\Seeders\Testing;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class DeleteTestBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Deletes all test blog posts created by TestBlogSeeder
     */
    public function run(): void
    {
        $this->command->info('Deleting test blogs...');

        // Delete blogs with 'test-blog' tag
        $deletedCount = Blog::whereJsonContains('tags', 'test-blog')->delete();

        if ($deletedCount > 0) {
            $this->command->info("Successfully deleted {$deletedCount} test blogs!");
        } else {
            $this->command->warn('No test blogs found to delete.');
        }
    }
}
