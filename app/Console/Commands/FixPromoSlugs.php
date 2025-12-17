<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promo;

class FixPromoSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:fix-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbaiki semua slug promo yang lama menjadi slug berdasarkan nama.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memperbaiki slug promo...');

        $promos = Promo::all();

        foreach ($promos as $promo) {
            // Gunakan fungsi yang sudah kita buat di Model
            $newSlug = $promo->generateUniqueSlug($promo->name);

            // Hanya update jika slug berubah
            if ($promo->slug !== $newSlug) {
                $promo->slug = $newSlug;
                $promo->save();
                $this->line("Promo '{$promo->name}' slug diubah menjadi: {$newSlug}");
            }
        }

        $this->info('Semua slug telah diperbaiki!');
        return Command::SUCCESS;
    }
}
    