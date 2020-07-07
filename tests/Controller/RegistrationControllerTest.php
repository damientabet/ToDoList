<?php
namespace Tests\Controller;

use App\DataFixtures\TaskFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function setUp(): void
    {
        $this->loadFixtures([
            TaskFixtures::class
        ], false, null, 'doctrine', true);
    }

    public function testRegister()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'administrateur@todolist.com',
            'PHP_AUTH_PW'   => 'admintest',
        ]);

        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[username]'] = 'Test';
        $form['registration_form[password][first]'] = 'test';
        $form['registration_form[password][second]'] = 'test';
        $form['registration_form[email]'] = 'test@test.fr';
        $form['registration_form[roles]'] = 'ROLE_USER';
        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        echo $client->getResponse()->getContent();
    }
}
