<?php


namespace App\Controller\Api;

use App\Service\Category\CategoryService;
use App\Util\Api;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/category")
 */
class Category extends Api
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
     */
    public function add(Request $request, CategoryService $categoryService): JsonResponse
    {
        try {
            $categoryService->addNew($request);
            return $this->getSuccessResponse('Add new category');
        } catch (Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}