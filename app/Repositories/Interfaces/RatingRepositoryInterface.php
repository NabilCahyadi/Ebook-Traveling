<?php

namespace App\Repositories\Interfaces;

use App\Models\Rating; // Sesuaikan dengan nama model Anda, misalnya 'EbookRating'

interface RatingRepositoryInterface
{
    public function findByUserAndEbook(string $userId, string $ebookId): ?Rating;
    public function create(array $data): Rating;
    public function update(string $id, array $data): bool;
}
