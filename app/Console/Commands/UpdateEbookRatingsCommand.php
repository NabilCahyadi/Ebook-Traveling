<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ebook;
use App\Models\Rating;

class UpdateEbookRatingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-ebook-ratings-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses update rating dan total review untuk semua ebook...');

        $ebooks = Ebook::has('ratings')->get();

        foreach ($ebooks as $ebook) {
            // Gunakan logika yang sudah diperbaiki dengan where('is_approved', 1)
            $stats = $ebook->ratings()
                ->where('is_approved', 1)
                ->selectRaw('COUNT(*) as total_reviews, AVG(rating) as average_rating')
                ->first();

            $ebook->total_reviews = $stats->total_reviews ?? 0;
            $ebook->average_rating = round($stats->average_rating ?? 0, 2);
            $ebook->save();

            $this->line("Updated: {$ebook->title}");
        }

        $this->info('Proses selesai! Semua data rating dan review telah diperbarui.');
    }
}
