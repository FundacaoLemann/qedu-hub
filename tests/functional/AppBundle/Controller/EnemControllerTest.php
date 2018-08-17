<?php

namespace Tests\Functional\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixture\Database\SchoolTableFixture;

class EnemControllerTest extends WebTestCase
{
    private $schoolTableFixture;

    public function testNonExistentEnemSchoolPage()
    {
        $client = static::createClient();

        $client->request('GET', 'escola/191105-pro-cultura-colegio/enem-dev');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(404, $statusCode);
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->schoolTableFixture = new SchoolTableFixture();
        $this->schoolTableFixture->createTable($kernel);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->schoolTableFixture->dropTable();
    }
}
