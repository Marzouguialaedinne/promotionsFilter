<?php

namespace App\Filter\Factory;

use App\Filter\PromotionType\PromotionFilterTypeInterface;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class CreateTypePromotion implements PromotionTypeInterface
{
	public function create(string $typePromotion): PromotionFilterTypeInterface
	{
		$promotionType = str_replace('_', '',ucwords($typePromotion, '_'));

		$className = self::BASE_PATH_PROMOTION_FILTER . $promotionType;

		if(!class_exists($className)) {
			throw new ClassNotFoundException($className);
		}

		return new $className;
	}
}