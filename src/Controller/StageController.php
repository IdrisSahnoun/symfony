<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\Resume;
use App\Form\StageType;
use App\Form\ResumeType;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/stage')]
class StageController extends AbstractController
{
    #[Route('/list', name: 'stages_list', methods: ['GET'])]
    public function stagesList(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->findAll();

        return $this->render('home/home.html.twig', [
            'stages' => $stages,
        ]);
    }

    #[Route('/details/{id}', name: 'stage_details', methods: ['GET', 'POST'])]
    public function stageDetails(Stage $stage, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResumeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle the resume upload
            $resume = $form->get('resume')->getData();
            if ($resume) {
                $originalFilename = pathinfo($resume->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid().'.'.$resume->guessExtension();

                // Move the file to the directory where resumes are stored
                try {
                    $resume->move(
                        $this->getParameter('resumes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                // Save the resume file and associate it with the stage
                $resumeEntity = new Resume();
                $resumeEntity->setFilename($newFilename);
                $resumeEntity->setStage($stage);
                $entityManager->persist($resumeEntity);
                $entityManager->flush();
            }

            $this->addFlash('success', 'Resume uploaded successfully!');
            return $this->redirectToRoute('stage_details', ['id' => $stage->getId()]);
        }

        return $this->render('home/stage_details.html.twig', [
            'stage' => $stage,
            'resumeForm' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_stage_index', methods: ['GET'])]
    public function index(StageRepository $stageRepository): Response
    {
        return $this->render('stage/index.html.twig', [
            'stages' => $stageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stage/new.html.twig', [
            'stage' => $stage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stage_show', methods: ['GET'])]
    public function show(Stage $stage): Response
    {
        return $this->render('stage/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stage $stage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stage/edit.html.twig', [
            'stage' => $stage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stage_delete', methods: ['POST'])]
    public function delete(Request $request, Stage $stage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stage_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/backoffice', name: 'backoffice', methods: ['GET'])]
    public function backoffice(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->findAll();

        return $this->render('backoffice/backoffice.html.twig', [
            'stages' => $stages,
        ]);
    }
}