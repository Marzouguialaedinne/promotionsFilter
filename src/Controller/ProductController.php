<?php

namespace App\Controller;

use App\DTO\EnquiryDto;
use App\Filter\PromotionFilterInterface;
use App\Repository\ProductRepository;
use App\Repository\PromotionRepository;
use App\Service\Serializer\SerializerDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
	#[Route(path: '/product/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
	public function lowestPrice(
			$id,
			Request $request,
			SerializerDto $serializer,
			PromotionFilterInterface $promotionFilter,
			ProductRepository $productRepository,
			PromotionRepository $promotionRepository
	)
	{
		if($request->headers->has('force_fail')) {
			return new JsonResponse([
			    "message" => "failed forced !"
			], $request->headers->get('force_fail'));
		}

		$product = $productRepository->find($id); // handling Error if null

		// 1 : deserialize json content into EnquiryDto
		/** @var EnquiryDto $enquiryDto */
		$enquiryDto = $serializer->deserialize($request->getContent(), EnquiryDto::class, 'json');

		$enquiryDto->setProduct($product);

		$promotions = $promotionRepository->validPromotionProduct($product, date_create_immutable($enquiryDto->getRequestDate()));

		// 2 : apply modification price promotions
		$enquiryDto = $promotionFilter->apply($enquiryDto, ...$promotions);

		$contentResponse = $serializer->serialize($enquiryDto, 'json');

		return new Response($contentResponse, 200, ['Content-Type' => 'application/json']);
	}
}
