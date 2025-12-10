<?php

namespace App\Services;

use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Blog;

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
        // return $this->blogRepository->getPublished($perPage);
        return \App\Models\Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    // --- PERBAIKAN: Gunakan repository ---
    public function getBlogBySlug(string $slug)
    {
        return $this->blogRepository->getBySlug($slug);
    }

    // --- TAMBAHKAN METHOD INI ---
    public function getAllPublishedTags()
    {
        // Bisa langsung di service atau lewat repository
        return Blog::where('status', 'published')
            ->pluck('tags')
            ->flatten()
            ->unique();
    }

    // --- TAMBAHKAN METHOD INI ---
    public function getPublishedBlogsByTag(string $tag, int $perPage = 10)
    {
        // Bisa langsung di service atau lewat repository
        return Blog::where('status', 'published')
            ->whereJsonContains('tags', $tag)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    public function getBlogById(string $id)
    {
        return $this->blogRepository->getById($id);
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

        if (!$blog) {
            return false;
        }

        return $blog->delete(); // Soft delete
    }

    public function restoreBlog(string $id)
    {
        $blog = \App\Models\Blog::onlyTrashed()->find($id);

        if (!$blog) {
            return false;
        }

        return $blog->restore();
    }

    public function forceDeleteBlog(string $id)
    {
        $blog = \App\Models\Blog::onlyTrashed()->find($id);

        if (!$blog) {
            return false;
        }

        // Delete featured image if exists
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        return $blog->forceDelete();
    }

    public function getTrashedBlogs(int $perPage = 10)
    {
        return \App\Models\Blog::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);
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

    /**
     * Mendapatkan tag-tag yang paling populer dari blog-blog yang paling banyak dilihat.
     */
    public function getPopularTags(int $limit = 10)
    {
        // 1. Ambil 50 blog dengan view_count tertinggi YANG PASTI MEMILIKI TAG
        $popularBlogs = Blog::where('status', 'published')
            ->whereNotNull('tags') // <-- HANYA AMBIL YANG TAG-NYA TIDAK NULL
            ->where('tags', '!=', '[]') // DAN JUGA YANG BUKAN ARRAY KOSONG
            ->orderBy('view_count', 'desc')
            ->limit(50)
            ->get();

        if ($popularBlogs->isEmpty()) {
            return collect(); // Kembalikan collection kosong jika tidak ada blog populer
        }

        // 2. Dapatkan semua tag, lalu hitung frekuensinya
        $tagCounts = $popularBlogs
            ->pluck('tags')
            ->flatten()
            ->countBy();

        // 3. Urutkan tag berdasarkan frekuensi dan ambil sesuai limit
        $sortedTags = $tagCounts
            ->sortDesc()
            ->take($limit)
            ->keys();

        return $sortedTags;
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
        if (isset($data['status']) && $data['status'] && !isset($data['published_at'])) {
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
