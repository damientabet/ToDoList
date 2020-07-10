<?php
namespace Tests\Controller;

use App\Entity\Task;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client;
    use FixturesTrait;

    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'administrateur@todolist.com',
            'PHP_AUTH_PW'   => 'admintest',
        ]);
    }

    public function testIndex()
    {
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateTask()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Ma tâche de test';
        $form['task[content]'] = 'Plat de pâtes';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        echo $this->client->getResponse()->getContent();
    }

    public function testTaskList()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $this->client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info));

        $this->assertSame("Ma liste de tâches", $info);

        echo $this->client->getResponse()->getContent();
    }

    public function testEditTask()
    {
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Ma tâche')->link();
        $crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Ma tâche modifiée';
        $form['task[content]'] = 'Ma première tâche à été modifié';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        echo $this->client->getResponse()->getContent();
    }

    public function testDeleteTask()
    {
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Supprimer')->form();
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testToggleTask()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Marquer comme faite')->form();
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}
