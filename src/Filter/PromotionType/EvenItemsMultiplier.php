<?php

namespace App\Filter\PromotionType;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;

class EvenItemsMultiplier implements PromotionFilterTypeInterface
{
	public function modifier(int $price, int $quantity, EnquiryDtoInterface $enquiryDto, Promotion $promotion): int
	{
		if($enquiryDto->getQuantity() < $promotion->getCriteria()['minimum_quantity']) {
			return $price * $quantity;
		}

		$even = $quantity % 2;

		return (($quantity - $even)* $price * $promotion->getAdjustement()) + $price*$even;
	}
}