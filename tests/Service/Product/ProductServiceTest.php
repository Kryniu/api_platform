<?php

namespace App\Tests\Service\Product;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Product\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;

class ProductServiceTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|CategoryRepository $categoryRepository;
    private ObjectProphecy|EntityManagerInterface $entityManager;
    private ObjectProphecy|ProductRepository $productRepository;
    private Request|ObjectProphecy $request;

    protected function setUp(): void
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->categoryRepository = $this->prophesize(CategoryRepository::class);
        $this->productRepository = $this->prophesize(ProductRepository::class);
        $this->request = $this->prophesize(Request::class);
    }

    private function getProductService(): ProductService
    {
        return new ProductService($this->entityManager->reveal(), $this->categoryRepository->reveal(), $this->productRepository->reveal());
    }

    public function testGetListWithCategoriesReturnEmptyArray(): void
    {
        $this->productRepository->findAll()->willReturn([]);
        $productService = $this->getProductService();
        $this->assertEquals($productService->getListWithCategories(), []);
    }

    public function testAddNewEmptyValuesReturnException(): void
    {
        $this->expectException(\Exception::class);
        $productService = $this->getProductService();
        $this->request->get('name')->willReturn('');
        $this->request->get('symbol')->willReturn('');
        $this->request->get('categoryId')->willReturn('');
        $productService->addNew($this->request->reveal());
    }
}
