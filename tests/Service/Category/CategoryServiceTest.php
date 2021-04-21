<?php

namespace App\Tests\Service\Category;

use App\Service\Category\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;

class CategoryServiceTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|EntityManagerInterface $entityManager;
    private Request|ObjectProphecy $request;

    protected function setUp(): void
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->request = $this->prophesize(Request::class);
    }

    private function getCategoryService(): CategoryService
    {
        return new CategoryService($this->entityManager->reveal());
    }

    public function testAddNewEmptyValuesReturnException(): void
    {
        $this->expectException(\Exception::class);
        $productService = $this->getCategoryService();
        $this->request->get('name')->willReturn('');
        $productService->addNew($this->request->reveal());
    }
}
