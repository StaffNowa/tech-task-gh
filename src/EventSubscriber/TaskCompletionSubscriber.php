<?php

namespace App\EventSubscriber;

use App\Entity\Certification;
use App\Entity\Task;
use App\Event\TaskCompletionEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class TaskCompletionSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TaskCompletionEvent::class => 'onTaskCompletion',
        ];
    }

    public function onTaskCompletion(TaskCompletionEvent $event): void
    {
        $task = $this->entityManager->getRepository(Task::class)->findOneBy([
            'id' => $event->getTaskDetails()['taskId'],
        ]);
        if (!$task) {
            throw new \RuntimeException('Task not found', Response::HTTP_BAD_REQUEST);
        }

        foreach ($task->getFlight()->getGroundCrewMembers() as $groundCrewMember) {
            $certifications = $groundCrewMember->getCertifications();
            foreach ($certifications as $certification) {
                if ($certification->getValidUntil() < new Date()) {
                    $this->markCertificationExpired($certification);
                }
            }
        }
    }

    private function markCertificationExpired(Certification $certification): void
    {
        $certification->setExpired(true);
        $this->entityManager->flush();
    }
}
