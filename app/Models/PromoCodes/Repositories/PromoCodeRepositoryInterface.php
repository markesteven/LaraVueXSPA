<?php

namespace App\Models\PromoCodes\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\PromoCodes\PromoCode;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface PromoCodeRepositoryInterface extends BaseRepositoryInterface
{
    public function createPromoCode(array $data): PromoCode;

    public function findPromoCodeById(int $id) : PromoCode;

    public function updatePromoCode(array $data) : bool;

    public function deletePromoCode() : bool;

    public function listPromoCodes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    function getAllPromoCodes(Request $request);
}
