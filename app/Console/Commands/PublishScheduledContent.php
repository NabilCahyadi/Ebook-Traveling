<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use App\Models\Ebook;
use Carbon\Carbon;

class PublishScheduledContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all scheduled blogs and ebooks that have reached their publish date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $publishedBlogs = 0;
        $publishedEbooks = 0;

        // Publish scheduled blogs
        $scheduledBlogs = Blog::where('status', 'scheduled')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', $now)
            ->get();

        foreach ($scheduledBlogs as $blog) {
            $blog->update([
                'status' => 'published',
            ]);
            $publishedBlogs++;
            $this->info("Published blog: {$blog->title}");
        }

        // Publish scheduled ebooks
        $scheduledEbooks = Ebook::where('status', 'scheduled')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', $now)
            ->get();

        foreach ($scheduledEbooks as $ebook) {
            $ebook->update([
                'status' => 'published',
            ]);
            $publishedEbooks++;
            $this->info("Published ebook: {$ebook->title}");
        }

        $this->info("-----------------------------------");
        $this->info("Published {$publishedBlogs} blog(s) and {$publishedEbooks} ebook(s)");

        return Command::SUCCESS;
    }
}
