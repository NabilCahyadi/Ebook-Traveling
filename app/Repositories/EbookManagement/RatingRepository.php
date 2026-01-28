<?php

namespace App\Repositories\EbookManagement;

use App\Models\Rating; // Sesuaikan dengan nama model Anda
use App\Repositories\Interfaces\RatingRepositoryInterface;
use Illuminate\Support\Str;

class RatingRepository implements RatingRepositoryInterface
{
    protected $model;

    public function __construct(Rating $model)
    {
        $this->model = $model;
    }

    public function findByUserAndEbook(string $userId, string $ebookId): ?Rating
    {
        return $this->model->where('user_id', $userId)
                            ->where('ebook_id', $ebookId)
                            ->first();
    }

    public function create(array $data): Rating
    {
        // Tambahkan UUID untuk id
        $data['id'] = (string) Str::uuid();
        
        return $this->model->create($data);
    }

    public function update(string $id, array $data): bool
    {
        $rating = $this->model->find($id);
        if (!$rating) {
            return false;
        }
        return $rating->update($data);
    }
}
