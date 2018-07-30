<?php

namespace Tests\Functional\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixture\Database\CityTableFixture;
use Tests\Fixture\Database\ProficiencyTableFixture;
use Tests\Fixture\Database\SchoolTableFixture;
use Tests\Fixture\Database\SchoolLearningTableFixture;
use Tests\Fixture\Database\StateTableFixture;

class LearningControllerTest extends WebTestCase
{
    private $proficiencyTableFixture;
    private $schoolTableFixture;
    private $schoolLearningTableFixture;
    private $stateTableFixture;
    private $cityTableFixture;

    public function testExistentAMPSchoolPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/amp/escola/142950-em-fazenda-aguas-verdes/aprendizado');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Português, 9º ano', $crawler->filter('.proficiency-9-1 h3')->text());
        $this->assertContains('34', $crawler->filter('.proficiency-9-1 .percent-level')->text());
        $this->assertContains('37', $crawler->filter('.proficiency-9-1 .present_count')->text());
        $this->assertContains('12', $crawler->filter('.proficiency-9-1 .optimal_count')->text());
    }

    public function testNonExistentAMPSchoolPage()
    {
        $client = static::createClient();

        $client->request('GET', '/amp/escola/9999999-non-existent/aprendizado');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testExistentSchoolPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/escola/142950-em-fazenda-aguas-verdes/aprendizado');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Português, 9º ano', $crawler->filter('.proficiency-9-1 h3')->text());
        $this->assertContains('34', $crawler->filter('.proficiency-9-1 .percent-level')->text());
        $this->assertContains('37', $crawler->filter('.proficiency-9-1 .present_count')->text());
        $this->assertContains('12', $crawler->filter('.proficiency-9-1 .optimal_count')->text());
    }

    public function testNonExistentSchoolPage()
    {
        $client = static::createClient();

        $client->request('GET', '/escola/9999999-non-existent/aprendizado');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->proficiencyTableFixture = new ProficiencyTableFixture();
        $this->proficiencyTableFixture->createTable($kernel);
        $this->proficiencyTableFixture->populateWithSchoolRegister();

        $this->schoolTableFixture = new SchoolTableFixture();
        $this->schoolTableFixture->createTable($kernel);
        $this->schoolTableFixture->populateWithSchoolRegister();

        $this->stateTableFixture = new StateTableFixture();
        $this->stateTableFixture->loadEntityManager($kernel);
        $this->stateTableFixture->createStateTable();
        $this->stateTableFixture->populateWithStateRegister();

        $this->cityTableFixture = new CityTableFixture();
        $this->cityTableFixture->loadEntityManager($kernel);
        $this->cityTableFixture->createCityTable();
        $this->cityTableFixture->populateWithCityRegister();

        $this->schoolLearningTableFixture = new SchoolLearningTableFixture();
        $this->schoolLearningTableFixture->loadEntityManager($kernel);
        $this->schoolLearningTableFixture->createSchoolLearningTable();
        $this->schoolLearningTableFixture->populateWithSchoolRegister();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->proficiencyTableFixture->dropTable();

        $this->schoolTableFixture->dropTable();
    }
}
