<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/task/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();

        $tag1 = new Tag();
        $tag1->setName('pilne');
        $task->getTags()->add($tag1);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Request $request, Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
            'nr' => $request->query->get('nr'),
        ]);
    }

    #[Route('/task/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $originalTags = new ArrayCollection();

        foreach ($task->getTags() as $tag) {
            $originalTags->add($tag);
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalTags as $tag) {
                if (false === $task->getTags()->contains($tag)) {
                    $tag->getTasks()->removeElement($task);
                    $entityManager->persist($tag);
                }
            }

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_edit', ['id' => $request->get('id')]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
