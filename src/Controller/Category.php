<?php


namespace App\Controller;


use App\Form\CategoryAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class Category extends AbstractController
{
    #[Route('/add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryAddType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();
            $this->addFlash('success', 'category.added');
            return $this->redirectToRoute('app_category_add');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}