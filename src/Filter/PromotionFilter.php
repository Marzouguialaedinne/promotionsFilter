<?php

namespace App\Filter;

use App\DTO\EnquiryDtoInterface;

class PromotionFilter implements PromotionFilterInterface
{
	public function apply(EnquiryDtoInterface $enquiryDto): EnquiryDtoInterface
	{
		$enquiryDto->setPrice(100);
		$enquiryDto->setDiscountPrice(50);
		$enquiryDto->setPromotionId(3);
		$enquiryDto->setPromotionName('Black friday');

		return $enquiryDto;
	}
}