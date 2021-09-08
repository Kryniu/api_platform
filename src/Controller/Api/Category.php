<?php


namespace App\Controller\Api;

use App\Service\Category\CategoryService;
use App\Util\Api;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Category extends Api
{
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