<?php


namespace App\Controller;


use App\Form\ProductAddType;
use App\Service\Product\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class Product extends AbstractController
{

    /**
     * @Route("/add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductAddType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();
            $this->addFlash('success', 'product.added');
            return $this->redirectToRoute('app_product_add');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list_with_categories")
     * @param ProductService $productService
     * @return Response
     */
    public function listWithCategories(ProductService $productService): Response
    {
        return $this->render('list.html.twig', [
            'results' => $productService->getListWithCategories(),
        ]);
    }
}