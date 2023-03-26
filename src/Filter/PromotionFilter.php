<?php

namespace App\Filter;

use App\DTO\EnquiryDtoInterface;
use App\Entity\Promotion;
use App\Filter\Factory\CreateTypePromotion;
use App\Filter\Factory\PromotionTypeInterface;

class PromotionFilter implements PromotionFilterInterface
{
	public function __construct(private PromotionTypeInterface $promotionType)
	{
	}

	public function apply(EnquiryDtoInterface $enquiryDto, Promotion ...$promotions): EnquiryDtoInterface
	{
		$price       = $enquiryDto->getProduct()->getPrice();
		$quantity    = $enquiryDto->getQuantity();
		$lowestPrice = $price * $quantity;

		$enquiryDto->setPrice($price);

		foreach ($promotions as $promotion) {

			$promotionType = $this->promotionType->create($promotion->getType());
			$lowestFilter = $promotionType->modifier($price, $quantity, $enquiryDto, $promotion);

			if($lowestFilter < $lowestPrice) {
				$enquiryDto->setDiscountPrice($lowestFilter);
				$enquiryDto->setPromotionId($promotion->getId());
				$enquiryDto->setPromotionName($promotion->getName());
				$lowestPrice = $lowestFilter;
			}
		}

		return $enquiryDto;
	}
}