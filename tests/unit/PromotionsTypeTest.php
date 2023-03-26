<?php

namespace App\Tests\unit;

use App\DTO\EnquiryDto;
use App\Entity\Promotion;
use App\Filter\PromotionType\DateRangeMultiplier;
use App\Filter\PromotionType\EvenItemsMultiplier;
use App\Filter\PromotionType\FixedPriceVoucher;
use App\Tests\ServiceTest;

class PromotionsTypeTest extends ServiceTest
{
	/** @test  */
	public function date_range_multiplier_correctly_value()
	{
		$promotion = new Promotion();
		$promotion->setName('Black Friday half price sale');
		$promotion->setType('date_range_multiplier');
		$promotion->setAdjustement(0.5);
		$promotion->setCriteria(["from" => "2022-11-18", "to" => "2022-11-28"]);

		$enquiryDto = new EnquiryDto();
		$enquiryDto->setRequestDate("2022-11-25");

		$dateRangeMultiplier = new DateRangeMultiplier();
		$lowestPrice = $dateRangeMultiplier->modifier(100, 5, $enquiryDto, $promotion);
		$this->assertEquals(250, $lowestPrice);
	}

	/** @test  */
	public function fixed_price_voucher_correctly_value()
	{
		$promotion = new Promotion();
		$promotion->setName('Voucher OU812');
		$promotion->setAdjustement(100);
		$promotion->setCriteria(["code" => "OU812"]);
		$promotion->setType('fixed_price_voucher');

		$enquiryDto = new EnquiryDto();
		$enquiryDto->setVoucherCode("OU812");

		$fixedPriceVoucher = new FixedPriceVoucher();
		$lowestPrice = $fixedPriceVoucher->modifier(150, 5, $enquiryDto, $promotion);
		$this->assertEquals(500, $lowestPrice);
	}


	/** @test  */
	public function even_items_multiplier_correctly_value()
	{
		$promotion = new Promotion();
		$promotion->setName('Buy one get one free');
		$promotion->setAdjustement(0.5);
		$promotion->setCriteria(["minimum_quantity" => 2]);
		$promotion->setType('even_items_multiplier');

		$enquiryDto = new EnquiryDto();
		$enquiryDto->setQuantity(5);

		$eventItemMultiplier = new EvenItemsMultiplier();
		$lowestPrice = $eventItemMultiplier->modifier(100, 5, $enquiryDto, $promotion);
		$this->assertEquals(300, $lowestPrice);
	}


}