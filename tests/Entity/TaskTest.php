<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Task;

class TaskTest extends TestCase
{
    public function testGetTitle()
    {
        $task = new Task();
        $task->setTitle('title');

        $this->assertSame('title', $task->getTitle());
    }

    public function testGetContent()
    {
        $task = new Task();
        $task->setContent('content');

        $this->assertSame('content', $task->getContent());
    }

    public function testGetCreatedAt()
    {
        $task = new Task();
        $date = new \Datetime();
        $task->setCreatedAt($date);

        $this->assertSame($date, $task->getCreatedAt());
    }

    public function testGetUser()
    {
        $task = new Task();
        $user = new User();
        $task->setUser($user);

        $this->assertSame($user, $task->getUser());
    }

    public function testGetIsDone()
    {
        $task = new Task();
        $task->setIsDone(1);

        $this->assertSame(true,$task->getIsDone());
    }
}
