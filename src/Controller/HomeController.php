<?php

namespace App\Controller;

use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/backoffice', name: 'backoffice')]
    public function backoffice(): Response
    {
        return $this->render('backoffice.html.twig');
    }
    #[Route('/stages', name: 'stages_list', methods: ['GET'])]
    public function stagesList(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->findAll();

        return $this->render('home/home.html.twig', [
            'stages' => $stages,
        ]);
    }

    
}