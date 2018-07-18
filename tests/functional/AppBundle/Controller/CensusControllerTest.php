<?php

namespace Tests\Functional\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixture\Database\CityTableFixture;
use Tests\Fixture\Database\ProficiencyTableFixture;
use Tests\Fixture\Database\SchoolCensusTableFixture;
use Tests\Fixture\Database\SchoolLearningTableFixture;
use Tests\Fixture\Database\SchoolTableFixture;
use Tests\Fixture\Database\StateTableFixture;

class CensusControllerTest extends WebTestCase
{
    private $schoolTableFixture;
    private $schoolCensusTableFixture;
    private $stateTableFixture;
    private $cityTableFixture;
    private $proficiencyTableFixture;
    private $schoolLearningTableFixture;

    public function testExistentAboutSchoolPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/escola/142950-em-fazenda-aguas-verdes/sobre');

        $tables = $crawler->filter('.group-educacenso table');

        $generalInformation = $tables->eq(0)->filter('tr');
        $inepCode = $generalInformation->eq(0)->filter('td')->text();
        $phone = $generalInformation->eq(4)->filter('td')->text();

        $equipments = $tables->eq(6)->filter('tr');
        $hasDvd = $equipments->eq(0)->filter('td')->text();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals('31171166', $inepCode);
        $this->assertEquals('(35) 3851-1660', $phone);

        $this->assertEquals('Sim', $hasDvd);
    }

    public function testNonExistentAboutSchoolPage()
    {
        $client = static::createClient();

        $client->request('GET', '/escola/8888888-non-exist/sobre');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testExistentCensusSchoolPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/escola/142950-em-fazenda-aguas-verdes/censo-escolar');

        $tables = $crawler->filter('.group-educacenso table');

        $generalInformation = $tables->eq(0)->filter('tr');
        $inepCode = $generalInformation->eq(0)->filter('td')->text();
        $phone = $generalInformation->eq(4)->filter('td')->text();

        $equipments = $tables->eq(6)->filter('tr');
        $hasDvd = $equipments->eq(0)->filter('td')->text();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals('31171166', $inepCode);
        $this->assertEquals('(35) 3851-1660', $phone);

        $this->assertEquals('Sim', $hasDvd);
    }

    public function testNonExistentCensusSchoolPage()
    {
        $client = static::createClient();

        $client->request('GET', '/escola/8888888-non-exist/censo-escolar');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->schoolTableFixture = new SchoolTableFixture();
        $this->schoolTableFixture->createTable($kernel);
        $this->schoolTableFixture->populateWithSchoolRegister();

        $this->schoolCensusTableFixture = new SchoolCensusTableFixture();
        $this->schoolCensusTableFixture->loadEntityManager($kernel);
        $this->schoolCensusTableFixture->createSchoolCensusTable();
        $this->schoolCensusTableFixture->populateWithSchoolRegister();

        $this->stateTableFixture = new StateTableFixture();
        $this->stateTableFixture->loadEntityManager($kernel);
        $this->stateTableFixture->createStateTable();
        $this->stateTableFixture->populateWithStateRegister();

        $this->cityTableFixture = new CityTableFixture();
        $this->cityTableFixture->loadEntityManager($kernel);
        $this->cityTableFixture->createCityTable();
        $this->cityTableFixture->populateWithCityRegister();

        $this->proficiencyTableFixture = new ProficiencyTableFixture();
        $this->proficiencyTableFixture->createTable($kernel);
        $this->proficiencyTableFixture->populateWithSchoolRegister();

        $this->schoolLearningTableFixture = new SchoolLearningTableFixture();
        $this->schoolLearningTableFixture->loadEntityManager($kernel);
        $this->schoolLearningTableFixture->createSchoolLearningTable();
        $this->schoolLearningTableFixture->populateWithSchoolRegister();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->schoolTableFixture->dropTable();

        $this->proficiencyTableFixture->dropTable();
    }
}
