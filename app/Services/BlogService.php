<?php

namespace App\Services;

use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class BlogService
{
    protected $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getAllBlogs()
    {
        return $this->blogRepository->getAll();
    }

    public function getPaginatedBlogs(int $perPage = 10)
    {
        return $this->blogRepository->getAllPaginated($perPage);
    }

    public function getPublishedBlogs(int $perPage = 10)
    {
        return $this->blogRepository->getPublished($perPage);
    }

    public function getBlogById(string $id)
    {
        return $this->blogRepository->getById($id);
    }

    public function getBlogBySlug(string $slug)
    {
        return $this->blogRepository->getBySlug($slug);
    }

    public function createBlog(array $data)
    {
        $processedData = $this->processData($data);
        return $this->blogRepository->create($processedData);
    }

    public function updateBlog(string $id, array $data)
    {
        $processedData = $this->processData($data, $id);
        return $this->blogRepository->update($id, $processedData);
    }

    public function deleteBlog(string $id)
    {
        $blog = $this->getBlogById($id);

        // Delete featured image if exists
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        return $this->blogRepository->delete($id);
    }

    public function incrementViewCount(string $id)
    {
        return $this->blogRepository->incrementViewCount($id);
    }

    public function getFilteredBlogs(array $filters, int $perPage = 15)
    {
        return $this->blogRepository->getFiltered($filters, $perPage);
    }

    public function getArchivedBlogs(?string $search = null, int $perPage = 15)
    {
        return $this->blogRepository->getArchived($search, $perPage);
    }

    public function getAllCategories()
    {
        return $this->blogRepository->getAllCategories();
    }

    protected function processData(array $data, ?string $id = null)
    {
        // Generate slug from title
        if (isset($data['title'])) {
            $slug = Str::slug($data['title']);

            // Make slug unique
            $originalSlug = $slug;
            $count = 1;
            while ($this->slugExists($slug, $id)) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $data['slug'] = $slug;
        }

        // Process tags
        if (isset($data['tags'])) {
            if (is_string($data['tags'])) {
                $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
            }
        } else {
            $data['tags'] = [];
        }

        // Handle featured image upload
        if (isset($data['featured_image']) && $data['featured_image']) {
            $file = $data['featured_image'];
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blogs', $filename, 'public');
            $data['featured_image'] = $path;
        } elseif (isset($data['remove_image']) && $data['remove_image']) {
            // Remove existing image
            if ($id) {
                $blog = $this->getBlogById($id);
                if ($blog->featured_image) {
                    Storage::disk('public')->delete($blog->featured_image);
                }
            }
            $data['featured_image'] = null;
        } else {
            // Keep existing image
            if ($id) {
                $blog = $this->getBlogById($id);
                $data['featured_image'] = $blog->featured_image;
            }
        }

        // Set published_at if publishing
        if (isset($data['is_published']) && $data['is_published'] && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Auto-generate excerpt if not provided
        if (empty($data['excerpt']) && isset($data['content'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 200);
        }

        return $data;
    }

    protected function slugExists(string $slug, ?string $excludeId = null): bool
    {
        $query = \App\Models\Blog::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getLatestForHomepage(int $limit = 4): Collection
    {
        return $this->blogRepository->getLatestPublished($limit);
    }
}
