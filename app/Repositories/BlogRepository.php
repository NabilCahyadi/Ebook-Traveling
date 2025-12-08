<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function getLatestPublished(int $limit = 4): Collection
    {
        // Gunakan scopePublished() dari model dan muat relasi 'author'
        return Blog::with('author')
            ->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
