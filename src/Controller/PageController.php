<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'home_active' => true,  // Set home_active to true for the homepage
            'shop_active' => false,
            'chat_active' => false,
            'reclamation_active' => false,  
        ]);
    }

    #[Route('/chat', name: 'app_chat')]
    public function contact(): Response
    {
        return $this->render('page/chat.html.twig', [
            'home_active' => false,
            'shop_active' => false,
            'chat_active' => true,  // Set chat_active to true for the contact page
            'reclamation_active' => false,  
        ]);
    }

    #[Route('/shop', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('page/shop.html.twig', [
            'home_active' => false,
            'shop_active' => true,  // Set shop_active to true for the shop page
            'chat_active' => false,
            'reclamation_active' => false,  
        ]);
    }

    #[Route('/reclamation', name: 'app_reclamation')]
    public function blog(): Response
    {
        return $this->render('page/chat.html.twig', [
            'home_active' => false,
            'shop_active' => false,
            'chat_active' => false,
            'reclamation_active' => true, // Set reclamation_active to true for the blog page
        ]);
    }
}
