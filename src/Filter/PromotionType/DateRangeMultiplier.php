<?php

namespace App\Filter\PromotionType;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;

class DateRangeMultiplier implements PromotionFilterTypeInterface
{

	public function modifier(int $price, int $quantity, EnquiryDtoInterface $enquiryDto, Promotion $promotion): int
	{
		$requestDate = date_create_immutable($enquiryDto->getRequestDate());
		$from        = date_create_immutable($promotion->getCriteria()['from']);
		$to          = date_create_immutable($promotion->getCriteria()['to']);

		if($requestDate < $from && $requestDate > $to) {
			return  $price * $quantity;
		}

		return $quantity * $price * $promotion->getAdjustement();
	}
}