<?php


namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function useUser($username)
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByUsername($username);

        $client->loginUser($testUser);

        return $client;
    }

    public function testList()
    {
        $client = $this->useUser('admin');

        $crawler = $client->request('GET', '/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListUserRole()
    {
        $client = $this->useUser('user');

        $crawler = $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testListUserAnonymous()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $time = time();
        $client = $this->useUser('admin');
        $crawler = $client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'user_new ' . $time;
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'user_new@' . $time .'.com';
        $form['user[roles]'] = 'ROLE_USER';
        $client->submit($form);
        $client->followRedirect();
        $this->assertContains("a bien été ajouté", $client->getResponse()->getContent());
    }

    public function testEditAction()
    {
        $time = time();
        $client = $this->useUser('admin');
        $crawler = $client->request('GET', '/users/3/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'user_modified ' . $time;
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'user_modified@' . $time .'.com';
        $form['user[roles]'] = 'ROLE_USER';
        $client->submit($form);
        $client->followRedirect();
        $this->assertContains("a bien été modifié", $client->getResponse()->getContent());
    }
}
