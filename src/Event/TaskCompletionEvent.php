<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TaskCompletionEvent extends Event
{
    public const NAME = 'task.completion';

    /**
     * @param array<string, int|string> $taskDetails
     */
    public function __construct(private readonly array $taskDetails)
    {
    }

    /**
     * @return int[]|string[]
     */
    public function getTaskDetails(): array
    {
        return $this->taskDetails;
    }
}
