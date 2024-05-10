<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\Task;
use App\Form\Type\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly ObjectService $objectService,
        private readonly FormFactoryInterface $formFactory,
        private readonly ValidatorInterface $validator,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return Task[]
     */
    public function getAllTasks(): array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * @return Task|array<int, string>
     */
    public function addTask(string $requestData): Task|array
    {
        $decodedRequestData = json_decode($requestData, true);
        $entity = new Task();
        $form = $this->formFactory->create(TaskType::class, $entity);
        $form->submit($decodedRequestData);

        $flightId = $decodedRequestData['flightId'] ?? null;
        $flightEntity = $this->entityManager->getRepository(Flight::class)->find($flightId);
        $entity->setFlight($flightEntity);

        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            return $this->objectService->handleErrors($errors);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
