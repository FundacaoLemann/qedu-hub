<?php

namespace Tests\Functional\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AboutControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sobre');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Sobre o QEdu', $crawler->filter('.container h1')->text());
    }
}
