<?php
namespace Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
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

    public function testUserList()
    {
        $crawler = $this->client->request('GET', '/users');
        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); // On retire les retours à la ligne pour faciliter la vérification

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame("Liste des utilisateurs", $info);

        echo $this->client->getResponse()->getContent();
    }

    public function testEditUser()
    {
        $crawler = $this->client->request('GET', '/users/2/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['registration_form[username]'] = 'Test2';
        $form['registration_form[password][first]'] = 'test';
        $form['registration_form[password][second]'] = 'test';
        $form['registration_form[email]'] = 'test2@test.fr';
        $form['registration_form[roles]'] = 'ROLE_USER';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        echo $this->client->getResponse()->getContent();
    }
}
