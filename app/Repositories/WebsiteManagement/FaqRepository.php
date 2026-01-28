<?php

// app/Repositories/WebsiteManagement/FaqRepository.php

namespace App\Repositories\WebsiteManagement;

use App\Models\Faq;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FaqRepository implements FaqRepositoryInterface
{
    protected $model;

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }

    public function getActiveByCategory(string $category): Collection
    {
        // Menggunakan 'order_index' untuk mengurutkan
        return $this->model->where('is_active', true)
            ->where('category', $category)
            ->orderBy('order_index', 'asc')
            ->get();
    }

    public function getAllByCategory(string $category, $perPage = 10)
    {
        return $this->model->where('category', $category)
            ->orderBy('order_index', 'asc')
            ->paginate($perPage);
    }

    public function findById(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['id'] = Str::uuid();
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $faq = $this->findById($id);
        $faq->update($data);
        return $faq;
    }

    public function delete(string $id)
    {
        $faq = $this->findById($id);
        return $faq->delete();
    }

    public function toggleStatus(string $id)
    {
        $faq = $this->findById($id);
        $faq->is_active = !$faq->is_active;
        $faq->save();
        return $faq;
    }

    public function updateOrder(array $orders)
    {
        foreach ($orders as $order) {
            $this->model->where('id', $order['id'])
                ->update(['order_index' => $order['order_index']]);
        }
    }

    public function bulkDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
