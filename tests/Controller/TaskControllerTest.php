<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function useUser($username)
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $testUser = $userRepository->findOneByUsername($username);

        $client->loginUser($testUser);

        return $client;
    }

    public function testListAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDoneListAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/done');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $client = $this->useUser('admin');

        $crawler = $client->request('GET', '/tasks');
        $link = $crawler->selectLink('Créer une tâche')->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->selectButton("Ajouter")->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'test create title';
        $form['task[content]'] = 'test create content';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('test create title', $client->getResponse()->getContent());
        $this->assertContains('test create content', $client->getResponse()->getContent());
    }

    public function testToggleTaskAction()
    {
        $client = $this->useUser('user');
        $crawler = $client->request('GET', '/tasks/1/toggle');
        $client->followRedirect();
        $this->assertContains("a bien été marquée", $client->getResponse()->getContent());
    }

    public function testEditAction()
    {
        $client = $this->useUser('admin');;

        $crawler = $client->request('GET', '/tasks');
        $link = $crawler->selectLink('test create title')->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->selectButton("Modifier")->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'test create title edited';
        $form['task[content]'] = 'test create content edited version';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('test create title edited', $client->getResponse()->getContent());
        $this->assertContains('test create content edited version', $client->getResponse()->getContent());
    }

    public function testDeleteTaskAction()
    {
        $client = $this->useUser('admin');

        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton('Supprimer')->last()->form();
        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertCount(1, $crawler->filter('div.alert.alert-success'));
    }
}
