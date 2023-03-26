<?php

namespace App\Filter;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;

interface PromotionFilterInterface
{
	public function apply(EnquiryDtoInterface $enquiryDto, Promotion ...$promotion): EnquiryDtoInterface;

}