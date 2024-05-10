<?php

namespace App\Controller;

use App\Entity\Task;
use App\Event\TaskCompletionEvent;
use App\Service\TaskService;
use Doctrine\ORM\Exception\MissingIdentifierField;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route('/tasks')]
class TaskController extends AbstractController
{
    public function __construct(private readonly TaskService $taskService, private readonly LoggerInterface $logger, private readonly EventDispatcherInterface $dispatcher)
    {
    }

    #[Route('/list', name: 'task_list', methods: ['GET'])]
    public function getTasks(): JsonResponse
    {
        return $this->json($this->taskService->getAllTasks());
    }

    #[Route('/add', name: 'task_add', methods: ['POST'])]
    public function addTask(Request $request): JsonResponse
    {
        try {
            $task = $this->taskService->addTask($request->getContent());
        } catch (\InvalidArgumentException|MissingIdentifierField $exception) {
            $this->logger->error('Bad request: ' . $exception->getMessage());

            return $this->json(['errors' => ['Bad request']], Response::HTTP_BAD_REQUEST);
        }

        if (!$task instanceof Task) {
            return $this->json(['errors' => $task], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Task created successfully'], Response::HTTP_CREATED);
    }

    #[Route('/complete-task/{taskId}', name: 'task_complete', methods: ['GET'])]
    public function completeTask(int $taskId): JsonResponse
    {
        try {
            $this->dispatcher->dispatch(new TaskCompletionEvent([
                'taskId' => $taskId,
            ]));
        } catch (\RuntimeException $runtimeException) {
            return $this->json(['errors' => [$runtimeException->getMessage()]], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Task completed successfully'], Response::HTTP_CREATED);
    }
}
