<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ObjectService
{
    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly ValidatorInterface $validator,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function addObject(string $requestData, string $formType, string $entityClass): mixed
    {
        $entity = new $entityClass();
        $form = $this->formFactory->create($formType, $entity);
        $form->submit(json_decode($requestData, true));

        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            return $this->handleErrors($errors);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    /**
     * @return array<int, string>
     */
    public function handleErrors(ConstraintViolationListInterface $errors): array
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = sprintf('Field: %s, Message: %s', $error->getPropertyPath(), $error->getMessage());
        }

        return $errorMessages;
    }
}
