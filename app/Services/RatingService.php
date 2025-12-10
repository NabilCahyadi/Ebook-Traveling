<?php

namespace App\Services;

use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Models\User; // Untuk cek subscription
use Illuminate\Support\Facades\Auth;

class RatingService
{
    protected $ratingRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * Proses utama untuk submit atau update rating.
     */
    public function submitRating(array $validatedData, string $userId): array
    {
        // 1. Cek apakah user sudah login dan premium
        // Logika ini bisa dipindah ke method di User Model atau service lain
        $user = User::find($userId);
        if (!$user || !$user->hasActiveSubscription()) {
            return [
                'success' => false,
                'message' => 'Fitur ini hanya tersedia untuk pengguna Premium.',
                'redirect_route' => 'pricing'
            ];
        }

        // 2. Cek apakah user sudah pernah memberi rating
        $existingRating = $this->ratingRepository->findByUserAndEbook($userId, $validatedData['ebook_id']);

        if ($existingRating) {
            // 3a. Jika sudah ada, update rating yang lama
            $this->ratingRepository->update($existingRating->id, $validatedData);
            $message = 'Rating Anda berhasil diperbarui!';
        } else {
            // 3b. Jika belum ada, buat rating baru
            $validatedData['user_id'] = $userId;
            $this->ratingRepository->create($validatedData);
            $message = 'Terima kasih! Rating dan review Anda berhasil ditambahkan!';
        }

        return [
            'success' => true,
            'message' => $message
        ];
    }
}
