<?php

namespace App\Filter;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;

class PromotionFilter implements PromotionFilterInterface
{
	public function apply(EnquiryDtoInterface $enquiryDto, Promotion ...$promotions): EnquiryDtoInterface
	{
		$price       = $enquiryDto->getProduct()->getPrice();
		$quantity    = $enquiryDto->getQuantity();
		$lowestPrice = $price * $quantity;

		foreach ($promotions as $promotion) {
			dd($promotion);

		}

		$enquiryDto->setPrice(100);
		$enquiryDto->setDiscountPrice(50);
		$enquiryDto->setPromotionId(3);
		$enquiryDto->setPromotionName('Black friday');

		return $enquiryDto;
	}
}