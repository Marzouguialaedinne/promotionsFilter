<?php

namespace App\Controller;

use App\DTO\EnquiryDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
	#[Route(path: '/product/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
	public function lowestPrice($id, Request $request, SerializerInterface $serializer)
	{
		if($request->headers->has('force_fail')) {
			return new JsonResponse([
			    "message" => "failed forced !"
			], $request->headers->get('force_fail'));
		}

		// 1 : deserialize json content into EnquiryDto
		/** @var EnquiryDto $enquiryDto */
		$enquiryDto = $serializer->deserialize($request->getContent(), EnquiryDto::class, 'json');

		// 2 : apply modification price promotions
		$enquiryDto->setPrice(100);
		$enquiryDto->setDiscountPrice(50);
		$enquiryDto->setPromotionId(3);
		$enquiryDto->setPromotionName('Black friday');

		$contentResponse = $serializer->serialize($enquiryDto, 'json');

		return new Response($contentResponse, 200, ['Content-Type' => 'application/json']);
	}
}
