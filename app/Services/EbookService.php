<?php

namespace App\Services;

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
    public function getAllEbooks(int $perPage = 15)
    {
        return $this->ebookRepository->getAllPaginated($perPage);
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
    public function getEbookById(int $id): ?Ebook
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
            // Handle file uploads
            if (isset($data['cover_image'])) {
                $data['cover_image'] = $data['cover_image']->store('ebooks/covers', 'public');
            }

            if (isset($data['file_url'])) {
                $data['file_url'] = $data['file_url']->store('ebooks/files', 'public');
            }

            if (isset($data['pdf_file'])) {
                $data['pdf_file'] = $data['pdf_file']->store('ebooks/pdfs', 'public');
            }

            $ebook = $this->ebookRepository->create($data);

            DB::commit();
            return $ebook;
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded files if transaction fails
            if (isset($data['cover_image']) && is_string($data['cover_image'])) {
                Storage::disk('public')->delete($data['cover_image']);
            }
            if (isset($data['file_url']) && is_string($data['file_url'])) {
                Storage::disk('public')->delete($data['file_url']);
            }
            if (isset($data['pdf_file']) && is_string($data['pdf_file'])) {
                Storage::disk('public')->delete($data['pdf_file']);
            }

            throw $e;
        }
    }

    /**
     * Update ebook.
     */
    public function updateEbook(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $ebook = $this->ebookRepository->findById($id);

            if (!$ebook) {
                throw new \Exception('Ebook not found');
            }

            // Handle file uploads
            if (isset($data['cover_image'])) {
                // Delete old cover
                if ($ebook->cover_image) {
                    Storage::disk('public')->delete($ebook->cover_image);
                }
                $data['cover_image'] = $data['cover_image']->store('ebooks/covers', 'public');
            }

            if (isset($data['file_url'])) {
                // Delete old file
                if ($ebook->file_url) {
                    Storage::disk('public')->delete($ebook->file_url);
                }
                $data['file_url'] = $data['file_url']->store('ebooks/files', 'public');
            }

            if (isset($data['pdf_file'])) {
                // Delete old PDF
                if ($ebook->pdf_file) {
                    Storage::disk('public')->delete($ebook->pdf_file);
                }
                $data['pdf_file'] = $data['pdf_file']->store('ebooks/pdfs', 'public');
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
     * Delete ebook.
     */
    public function deleteEbook(int $id): bool
    {
        DB::beginTransaction();
        try {
            $ebook = $this->ebookRepository->findById($id);

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
            if ($ebook->pdf_file) {
                Storage::disk('public')->delete($ebook->pdf_file);
            }

            $result = $this->ebookRepository->delete($ebook);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
