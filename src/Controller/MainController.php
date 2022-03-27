<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'categories' => $categoriesRepository->findBy([], ['categoryOrder' => 'ASC'])
        ]);
    }
}
