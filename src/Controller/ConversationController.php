<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Form\ConversationType;
use App\Repository\ConversationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conversation')]
class ConversationController extends AbstractController
{
    #[Route('/', name: 'app_conversation_index', methods: ['GET'])]
    public function index(ConversationRepository $conversationRepository): Response
    {
        return $this->render('conversation/index.html.twig', [
            'conversations' => $conversationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_conversation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $conversation = new Conversation();
        // La date de début est déjà définie à la date du système dans le constructeur de l'entité
        $conversation->setProductId(1);
        $conversation->setMessageId(1);
        $conversation->setParticipant(1);

        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($conversation);
            $entityManager->flush();

            return $this->redirectToRoute('app_conversation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conversation/new.html.twig', [
            'conversation' => $conversation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conversation_show', methods: ['GET'])]
    public function show(Conversation $conversation): Response
    {
        return $this->render('conversation/show.html.twig', [
            'conversation' => $conversation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conversation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conversation $conversation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConversationType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_conversation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conversation/edit.html.twig', [
            'conversation' => $conversation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conversation_delete', methods: ['POST'])]
    public function delete(Request $request, Conversation $conversation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conversation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($conversation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_conversation_index', [], Response::HTTP_SEE_OTHER);
    }
}