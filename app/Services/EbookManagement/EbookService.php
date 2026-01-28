<?php

namespace App\Services\EbookManagement;

use App\Models\Ebook;
use App\Repositories\Interfaces\EbookRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EbookService
{
    protected $ebookRepository;

    public function __construct(EbookRepositoryInterface $ebookRepository)
    {
        $this->ebookRepository = $ebookRepository;
    }

    /**
     * Get all ebooks with pagination.
     */
    public function getAllEbooks(
        int $perPage = 15,
        string $sortBy = 'created_at',
        string $sortOrder = 'desc',
        ?string $search = null,
        ?string $status = null,
        ?string $categoryId = null,
        ?string $cityId = null,
        ?string $statusExclude = null
    ) {
        return $this->ebookRepository->getAllPaginated($perPage, $sortBy, $sortOrder, $search, $status, $categoryId, $cityId, $statusExclude);
    }

    /**
     * Get active ebooks.
     */
    public function getActiveEbooks()
    {
        return $this->ebookRepository->getActive();
    }

    /**
     * Get ebook by ID.
     */
    public function getEbookById(string $id): ?Ebook
    {
        return $this->ebookRepository->findById($id);
    }

    /**
     * Get ebook by slug.
     */
    public function getEbookBySlug(string $slug): ?Ebook
    {
        return $this->ebookRepository->findBySlug($slug);
    }

    /**
     * Create a new ebook.
     */
    public function createEbook(array $data): Ebook
    {
        DB::beginTransaction();
        try {
            // cover_image is already processed as base64 in controller, no need to process here

            // Handle PDF file upload if provided
            if (isset($data['file_url']) && is_object($data['file_url'])) {
                $data['file_url'] = $data['file_url']->store('ebooks/files', 'public');
            }

            $ebook = $this->ebookRepository->create($data);

            DB::commit();
            return $ebook;
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded files if transaction fails
            if (isset($data['file_url']) && is_string($data['file_url'])) {
                Storage::disk('public')->delete($data['file_url']);
            }

            throw $e;
        }
    }

    /**
     * Update ebook.
     */
    public function updateEbook(string $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $ebook = $this->ebookRepository->findById($id);

            if (!$ebook) {
                throw new \Exception('Ebook not found');
            }

            // Handle cover image
            // Cover image sudah diproses di controller sebagai string (path dari base64)
            // Jadi hanya perlu delete old cover jika ada cover baru
            if (isset($data['cover_image']) && !empty($data['cover_image'])) {
                // Delete old cover
                if ($ebook->cover_image && $ebook->cover_image !== $data['cover_image']) {
                    Storage::disk('public')->delete($ebook->cover_image);
                }
                // $data['cover_image'] sudah berisi path string, tidak perlu store lagi
            }

            if (isset($data['file_url'])) {
                // Delete old file
                if ($ebook->file_url) {
                    Storage::disk('public')->delete($ebook->file_url);
                }
                $data['file_url'] = $data['file_url']->store('ebooks/files', 'public');
            }

            $result = $this->ebookRepository->update($ebook, $data);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete ebook (soft delete).
     */
    public function deleteEbook(string $id): bool
    {
        try {
            $ebook = $this->ebookRepository->findById($id);

            if (!$ebook) {
                throw new \Exception('Ebook not found');
            }

            return $ebook->delete(); // Soft delete
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Restore ebook.
     */
    public function restoreEbook(string $id): bool
    {
        $ebook = \App\Models\Ebook::onlyTrashed()->find($id);

        if (!$ebook) {
            return false;
        }

        return $ebook->restore();
    }

    /**
     * Permanently delete ebook.
     */
    public function forceDeleteEbook(string $id): bool
    {
        DB::beginTransaction();
        try {
            $ebook = \App\Models\Ebook::onlyTrashed()->find($id);

            if (!$ebook) {
                throw new \Exception('Ebook not found');
            }

            // Delete associated files
            if ($ebook->cover_image) {
                Storage::disk('public')->delete($ebook->cover_image);
            }
            if ($ebook->file_url) {
                Storage::disk('public')->delete($ebook->file_url);
            }

            $result = $ebook->forceDelete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get trashed ebooks.
     */
    public function getTrashedEbooks(int $perPage = 10)
    {
        return \App\Models\Ebook::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);
    }

    /**
     * Search ebooks.
     */
    public function searchEbooks(string $query)
    {
        return $this->ebookRepository->search($query);
    }

    /**
     * Get ebooks by category.
     */
    public function getEbooksByCategory(int $categoryId)
    {
        return $this->ebookRepository->getByCategory($categoryId);
    }

    /**
     * Get ebooks by city.
     */
    public function getEbooksByCity(int $cityId)
    {
        return $this->ebookRepository->getByCity($cityId);
    }
}
