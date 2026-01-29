<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ebook;

class TestViewTracking extends Command
{
    protected $signature = 'test:view-tracking {--ebook-id=} {--title=}';
    protected $description = 'Test view tracking untuk ebook tertentu';

    public function handle()
    {
        $ebookId = $this->option('ebook-id');
        $title = $this->option('title');

        if (!$ebookId && !$title) {
            $this->error('Specify either --ebook-id or --title');
            return;
        }

        // Cari ebook
        $query = Ebook::query();
        if ($ebookId) {
            $query->where('id', $ebookId);
        } else {
            $query->where('title', 'like', "%{$title}%");
        }

        $ebook = $query->first();

        if (!$ebook) {
            $this->error('Ebook not found');
            return;
        }

        $this->info("Ebook: {$ebook->title}");
        $this->info("Current view_count: {$ebook->view_count}");

        // Simulate increment
        $ebook->increment('view_count');
        $ebook->refresh();

        $this->info("New view_count: {$ebook->view_count}");
        $this->info("View tracking test completed!");
    }
}
