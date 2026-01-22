<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;

class BlogRepository implements BlogRepositoryInterface
{
    protected $model;

    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('author')->latest()->get();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->model->with('author')->latest()->paginate($perPage);
    }

    public function getPublished(int $perPage = 10)
    {
        return $this->model->published()->with('author')->latest('published_at')->paginate($perPage);
    }

    public function getById(string $id)
    {
        return $this->model->with('author')->findOrFail($id);
    }

    public function getBySlug(string $slug)
    {
        return $this->model->with('author')->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $blog = $this->getById($id);
        $blog->update($data);
        return $blog;
    }

    public function delete(string $id)
    {
        $blog = $this->getById($id);
        return $blog->delete();
    }

    public function incrementViewCount(string $id)
    {
        return $this->model->where('id', $id)->increment('view_count');
    }

    public function getFiltered(array $filters, int $perPage = 15)
    {
        $query = $this->model->with('author');

        // Filter by specific status if provided
        if (isset($filters['status']) && $filters['status'] && in_array($filters['status'], ['draft', 'published', 'unpublished'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by category
        if (isset($filters['category']) && $filters['category']) {
            $query->where('category', $filters['category']);
        }

        // Search
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Custom ordering: draft, published, unpublished
        $query->orderByRaw("FIELD(status, 'draft', 'published', 'unpublished')")
            ->latest('created_at');

        return $query->paginate($perPage);
    }

    public function getAllCategories()
    {
        return $this->model->select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
    }

    public function getLatestPublished(int $limit = 4)
    {
        return $this->model->where('status', 'published')
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }

    public function getArchived(?string $search = null, int $perPage = 15)
    {
        $query = $this->model->onlyTrashed()->with('author');

        // Add search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        return $query->latest('deleted_at')->paginate($perPage);
    }
}
