<?php
namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['email'] = 'administrateur@todolist.com';
        $form['password'] = 'admintest';
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();

        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info));

        $this->assertSame("Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !", $info);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @expectedExceptions
     */
    public function testLogout()
    {
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'administrateur@todolist.com',
//            'PHP_AUTH_PW'   => 'admintest',
//        ]);
//        $crawler = $client->request('GET', '/”');
//        $link = $crawler->selectLink('Se déconnecter')->link();
//        $client->click($link);

        $this->expectException('Logout');
//        $crawler = $client->followRedirect();
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
