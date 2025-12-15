<?php

// app/Services/FaqService.php

namespace App\Services;

use App\Repositories\Interfaces\FaqRepositoryInterface;
use Illuminate\Support\Collection;

class FaqService
{
    protected $repository;

    public function __construct(FaqRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPricingFaqs(): Collection
    {
        // Method ini khusus untuk halaman pricing
        return $this->repository->getActiveByCategory('pricing');
    }
}
