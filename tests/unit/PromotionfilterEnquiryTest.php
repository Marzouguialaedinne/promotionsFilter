<?php

namespace App\Tests\unit;
use App\DTO\EnquiryDto;
use App\Filter\PromotionFilter;
use App\Tests\ServiceTest;

class PromotionfilterEnquiryTest extends ServiceTest
{
	/** @test  */
	public function promotion_filter_enquiry_correctly_apply()
	{
		$enquiryDto = new EnquiryDto();

		/** @var PromotionFilter $promotionfilter */
		$promotionfilter = $this->container->get(PromotionFilter::class);

		/** @var EnquiryDto $enquiryApplyDTO */
		$enquiryApplyDTO = $promotionfilter->apply($enquiryDto);

		$this->assertEquals(100, $enquiryApplyDTO->getPrice());
		$this->assertEquals(50, $enquiryApplyDTO->getDiscountPrice());
		$this->assertEquals('Black friday', $enquiryApplyDTO->getPromotionName());
	}

}