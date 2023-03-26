<?php

namespace App\Filter;

use App\DTO\EnquiryDtoInterface;

interface PromotionFilterInterface
{
	public function apply(EnquiryDtoInterface $enquiryDto): EnquiryDtoInterface;

}