<?php


namespace App\Service\Category;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class CategoryService
{

    public function __construct(
        private EntityManagerInterface $entityManager
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
        if (empty($name)) {
            throw new Exception('Category name is empty');
        }
        $category = new Category();
        $category->setName($name);
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
}