<?php

namespace App\Tests\unit;
use App\DTO\EnquiryDto;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\PromotionFilter;
use App\Tests\ServiceTest;

class PromotionfilterEnquiryTest extends ServiceTest
{
	/** @test  */
	public function promotion_filter_enquiry_correctly_apply(): void
	{
		$enquiryDto = new EnquiryDto();
		$product    = new Product();
		$product->setPrice(100);

		$enquiryDto->setProduct($product);
		$enquiryDto->setQuantity(5);
		$enquiryDto->setRequestDate("2022-11-26");
		$enquiryDto->setVoucherCode("OU812");

		/** @var PromotionFilter $promotionfilter */
		$promotionfilter = $this->container->get(PromotionFilter::class);

		$promotions = $this->promotionsProvider();
		/** @var EnquiryDto $enquiryApplyDTO */
		$enquiryApplyDTO = $promotionfilter->apply($enquiryDto, ...$promotions);

		$this->assertEquals(100, $enquiryApplyDTO->getPrice());
		$this->assertEquals(250, $enquiryApplyDTO->getDiscountPrice());
		$this->assertEquals('Black Friday half price sale', $enquiryApplyDTO->getPromotionName());
	}


	public function promotionsProvider(): array
	{
		$promotionOne = new Promotion();
		$promotionOne->setName('Black Friday half price sale');
		$promotionOne->setType('date_range_multiplier');
		$promotionOne->setAdjustement(0.5);
		$promotionOne->setCriteria(["from" => "2022-11-18", "to" => "2022-11-28"]);

		$promotionTow = new Promotion();
		$promotionTow->setName('Voucher OU812');
		$promotionTow->setAdjustement(100);
		$promotionTow->setCriteria(["code" => "OU812"]);
		$promotionTow->setType('fixed_price_voucher');

		$promotionThree = new Promotion();
		$promotionThree->setName('Buy one get one free');
		$promotionThree->setAdjustement(0.5);
		$promotionThree->setCriteria(["minimum_quantity" => 2]);
		$promotionThree->setType('even_items_multiplier');

		return [$promotionOne, $promotionTow, $promotionThree];
	}

}