<?php

namespace App\Filter\PromotionType;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;

interface PromotionFilterTypeInterface
{
	public function modifier(int $price, int $quantity, EnquiryDtoInterface $enquiryDto, Promotion $promotion): int;

}