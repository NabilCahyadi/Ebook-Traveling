<?php

namespace App\Repositories;

use App\Models\Promo;
use App\Models\PromoCondition;
use App\Models\PromoUserUsage;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use Illuminate\Support\Facades\DB;


class PromoRepository implements PromoRepositoryInterface
{
    protected $model;

    /**
     * Constructor untuk menerima model dependency.
     */
    public function __construct(Promo $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return Promo::with('conditions', 'usages')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return Promo::with('conditions')
            ->withCount('usages')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getById(string $id)
    {
        return Promo::findOrFail($id);
    }

    public function getByCode(string $code)
    {
        return Promo::where('code', $code)->first();
    }

    public function findByCode($code)
    {
        return $this->model->where('code', $code)
            ->where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->first();
    }

    public function getAllActive()
    {
        return $this->model->where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get promos that are currently active and within their date range.
     */
    public function getAvailablePromos()
    {
        $now = \Carbon\Carbon::now();

        return $this->model->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)
            ->where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            // Create promo
            $promo = Promo::create([
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'description' => $data['description'] ?? null,
                'type' => $data['type'],
                'value' => $data['value'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'max_usage' => $data['max_usage'] ?? null,
                'max_usage_per_user' => $data['max_usage_per_user'],
                'current_usage' => 0,
                'is_active' => $data['is_active'] ?? true,
            ]);

            // Create conditions if provided
            if (isset($data['conditions']) && is_array($data['conditions'])) {
                foreach ($data['conditions'] as $condition) {
                    PromoCondition::create([
                        'promo_id' => $promo->id,
                        'condition_type' => $condition['condition_type'],
                        'condition_value' => $condition['condition_value'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return $promo->load('conditions');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $promo = $this->getById($id);

            // Update promo
            $promo->update([
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'description' => $data['description'] ?? null,
                'type' => $data['type'],
                'value' => $data['value'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'max_usage' => $data['max_usage'] ?? null,
                'max_usage_per_user' => $data['max_usage_per_user'],
                'is_active' => $data['is_active'] ?? $promo->is_active,
            ]);

            // Update conditions: delete old and create new
            if (isset($data['conditions'])) {
                $promo->conditions()->delete();

                if (is_array($data['conditions']) && count($data['conditions']) > 0) {
                    foreach ($data['conditions'] as $condition) {
                        PromoCondition::create([
                            'promo_id' => $promo->id,
                            'condition_type' => $condition['condition_type'],
                            'condition_value' => $condition['condition_value'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return $promo->load('conditions');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(string $id)
    {
        $promo = $this->getById($id);
        return $promo->delete();
    }

    public function toggleActive(string $id)
    {
        $promo = $this->getById($id);
        $promo->is_active = !$promo->is_active;
        $promo->save();
        return $promo;
    }

    public function incrementUsage(string $id)
    {
        $promo = $this->getById($id);
        $promo->increment('current_usage');
        return $promo;
    }

    public function checkUserUsage(string $promoId, string $userId)
    {
        return PromoUserUsage::where('promo_id', $promoId)
            ->where('user_id', $userId)
            ->count();
    }

    public function getPromoWithConditions(string $id)
    {
        return Promo::with('conditions')->findOrFail($id);
    }

    public function getPromoByCodeWithConditions(string $code)
    {
        return Promo::with('conditions')->where('code', $code)->first();
    }

    /**
     * Record promo usage by user.
     */
    public function recordUsage(array $data)
    {
        return PromoUserUsage::create($data);
    }

    public function getBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
