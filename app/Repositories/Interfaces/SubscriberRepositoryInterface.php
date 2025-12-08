<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SubscriberRepositoryInterface
{
    public function getFilteredSubscribers(array $filters, int $perPage = 15): LengthAwarePaginator;
}
