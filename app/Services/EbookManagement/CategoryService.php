<?php

namespace App\Services\EbookManagement;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Str;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(int $perPage = 10)
    {
        return $this->categoryRepository->paginate($perPage);
    }

    public function getCategoryById(string $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function createCategory(array $data)
    {
        // Generate slug from name
        $data['slug'] = Str::slug($data['name']);

        return $this->categoryRepository->create($data);
    }

    public function updateCategory(string $id, array $data)
    {
        // Regenerate slug if name is updated
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(string $id)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return false;
        }

        return $category->delete(); // Soft delete
    }

    public function restoreCategory(string $id)
    {
        $category = \App\Models\Category::onlyTrashed()->find($id);

        if (!$category) {
            return false;
        }

        return $category->restore();
    }

    public function forceDeleteCategory(string $id)
    {
        $category = \App\Models\Category::onlyTrashed()->find($id);

        if (!$category) {
            return false;
        }

        // Check if category has ebooks via pivot table
        $ebooksCount = $category->ebooks()->count();
        if ($ebooksCount > 0) {
            throw new \Exception('Cannot permanently delete category with existing ebooks!');
        }

        return $category->forceDelete();
    }

    public function getTrashedCategories(int $perPage = 10)
    {
        return \App\Models\Category::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);
    }

    public function getCategoryBySlug(string $slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function getHeaderCategories()
    {
        return $this->categoryRepository->getActiveParentCategories();
    }
}
