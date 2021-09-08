<?php


namespace App\Service\Product;


use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class ProductService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository
    )
    {
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addNew(Request $request): void
    {
        $name = $request->get('name');
        $symbol = $request->get('symbol');
        $categoryId = $request->get('categoryId');
        if (empty($name)) {
            throw new Exception('Product name is empty');
        }
        $category = $this->categoryRepository->find($categoryId);
        if (null === $category) {
            throw new Exception('Not found category id '. $categoryId);
        }
        $product = new Product();
        $product->setName($name);
        $product->setSymbol($symbol);
        $product->setCategory($category);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function getListWithCategories(): array
    {
        $products = $this->productRepository->findAll();
        $productList = [];
        foreach ($products as $product) {
            $productList[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'symbol' => $product->getSymbol(),
                'categoryName' => $product->getCategory()->getName(),
            ];
        }

        return $productList;
    }
}