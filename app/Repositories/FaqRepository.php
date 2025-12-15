<?php

// app/Repositories/FaqRepository.php

namespace App\Repositories;

use App\Models\Faq;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use Illuminate\Support\Collection;

class FaqRepository implements FaqRepositoryInterface
{
    protected $model;

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }

    public function getActiveByCategory(string $category): Collection
    {
        // Menggunakan 'order_index' untuk mengurutkan
        return $this->model->where('is_active', true)
            ->where('category', $category)
            ->orderBy('order_index', 'asc')
            ->get();
    }
}
