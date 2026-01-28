<?php

namespace App\Repositories\EbookManagement;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function find(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete(string $id)
    {
        $category = $this->find($id);
        return $category->delete();
    }

    public function withCount(string $relation)
    {
        return $this->model->withCount($relation);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function getActiveParentCategories()
    {
        return $this->model
            ->where('type', 'ebook')
            ->where('is_active', 1)
            ->whereNull('parent_id')
            ->orderBy('name', 'asc')
            ->get();
    }
}
