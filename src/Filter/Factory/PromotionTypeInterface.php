<?php

namespace App\Filter\Factory;

use App\Filter\PromotionType\PromotionFilterTypeInterface;

interface PromotionTypeInterface
{
	const BASE_PATH_PROMOTION_FILTER = "App\Filter\PromotionType\\";

	public function create(string $typePromotion): PromotionFilterTypeInterface;

}