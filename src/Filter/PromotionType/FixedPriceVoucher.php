<?php

namespace App\Filter\PromotionType;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;

class FixedPriceVoucher implements PromotionFilterTypeInterface
{
	public function modifier(int $price, int $quantity, EnquiryDtoInterface $enquiryDto, Promotion $promotion): int
	{
		if($enquiryDto->getVoucherCode() != $promotion->getCriteria()['code']) {
			return $price * $quantity;
		}

		return $quantity * $promotion->getAdjustement();
	}

}