<?php


namespace App\Tests\Entity;

use App\Entity\User;

class UserTest
{
    public function testCreateUser()
    {
        $user = new User();
        $username = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 6);

        $user->setUsername($username)
            ->setEmail($username.'@email.fr')
            ->setPlainPassword('azertyuiop')
            ->setRoles()
        ;

        $this->assertInstanceOf(User::class, $user);
    }
    public function testGetUsername()
    {
        $task = new User();
        $task->setUsername('name');

        $this->assertSame('name', $task->getUsername());
    }

    public function testGetPassword()
    {
        $task = new User();
        $task->setPassword('password');

        $this->assertSame('password', $task->getPassword());
    }

    public function testGetEmail()
    {
        $task = new User();
        $task->setEmail('test@test.com');

        $this->assertSame('test@test.com', $task->getEmail());
    }

    public function testGetRoles()
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    public function testGetToken()
    {
        $user = new User();
        $user->setToken('123456');
        $this->assertEquals('123456', $user->getToken());
    }

    public function testGetTokenCreatedAt()
    {
        $user = new User();
        $dateTime = new \DateTime();
        $user->setTokenCreatedAt($dateTime);
        $this->assertEquals($dateTime, $user->getTokenCreatedAt());
    }
}
