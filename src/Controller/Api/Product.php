<?php


namespace App\Controller\Api;

use App\Service\Product\ProductService;
use App\Util\Api;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/product")
 */
class Product extends Api
{
    /**
     * @Route("/add", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Returns success message",
     *     @OA\JsonContent(
     *          @OA\Property(type="string", property="message")
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Returns error message",
     *     @OA\JsonContent(
     *          @OA\Property(type="string", property="message")
     *     )
     * )
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     required=true,
     *     description="name",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="symbol",
     *     in="query",
     *     description="symbol",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="categoryId",
     *     in="query",
     *     description="categoryId",
     *     @OA\Schema(type="string")
     * )
     */
    public function add(Request $request, ProductService $productService): JsonResponse
    {
        try {
            $productService->addNew($request);
            return $this->getSuccessResponse('Add new product');
        } catch (Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    /**
     * @Route("/list_with_categories", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns success message ",
     *     @OA\JsonContent(
     *          @OA\Property(type="string", property="id"),
     *          @OA\Property(type="string", property="name"),
     *          @OA\Property(type="string", property="symbol"),
     *          @OA\Property(type="string", property="categoryName")
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Returns error message",
     *     @OA\JsonContent(
     *          @OA\Property(type="string", property="message")
     *     )
     * )
     */
    public function listWithCategories(ProductService $productService): JsonResponse
    {
        return new JsonResponse($productService->getListWithCategories(), Response::HTTP_OK);
    }
}