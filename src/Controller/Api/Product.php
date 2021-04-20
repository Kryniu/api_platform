<?php


namespace App\Controller\Api;

use App\Service\Product\ProductService;
use App\Util\Api;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Product extends Api
{
    public function add(Request $request, ProductService $productService): JsonResponse
    {
        try {
            $productService->addNew($request);
            return $this->getSuccessResponse('Add new product');
        } catch (Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function listWithCategories(ProductService $productService): JsonResponse
    {
        return new JsonResponse($productService->getListWithCategories(), Response::HTTP_OK);
    }
}