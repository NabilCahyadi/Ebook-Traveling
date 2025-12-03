<?php

namespace App\Services;

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

        // Check if category has ebooks via pivot table
        $ebooksCount = $category->ebooks()->count();
        if ($ebooksCount > 0) {
            throw new \Exception('Cannot delete category with existing ebooks!');
        }

        return $this->categoryRepository->delete($id);
    }

    public function getCategoryBySlug(string $slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }
}
