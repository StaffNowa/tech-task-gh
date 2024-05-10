<?php

namespace App\Tests\Event;

use App\Event\TaskCompletionEvent;
use PHPUnit\Framework\TestCase;

class TaskCompletionEventTest extends TestCase
{
    public function testGetTaskDetails(): void
    {
        $event = new TaskCompletionEvent([
            'id' => 1,
        ]);

        self::assertSame(['id' => 1], $event->getTaskDetails());
    }
}
