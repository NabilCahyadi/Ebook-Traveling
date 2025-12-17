<?php

namespace App\Services\Contracts;

interface PromoServiceInterface
{
    /**
     * Get all active promos
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivePromos();

    /**
     * Get promo by slug
     * 
     * @param string $slug
     * @return \App\Models\Promo|null
     */
    public function getPromoBySlug($slug);

    /**
     * Get promo by code
     * 
     * @param string $code
     * @return \App\Models\Promo|null
     */
    public function getPromoByCode($code);

    /**
     * Create a new promo
     * 
     * @param array $data
     * @return \App\Models\Promo
     */
    public function createPromo(array $data);

    /**
     * Update an existing promo
     * 
     * @param string $id
     * @param array $data
     * @return \App\Models\Promo
     */
    public function updatePromo($id, array $data);

    /**
     * Delete a promo
     * 
     * @param string $id
     * @return bool
     */
    public function deletePromo($id);
}
