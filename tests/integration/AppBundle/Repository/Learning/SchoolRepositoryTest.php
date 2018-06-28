<?php

namespace Tests\Integration\AppBundle\Repository\Learning;

use AppBundle\Entity\Learning\School;
use AppBundle\Learning\ProvaBrasilEdition;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Fixture\Database\SchoolLearningTableFixture;

class SchoolRepositoryTest extends KernelTestCase
{
    private $schoolLearningTableFixture;
    private $emSchool;

    public function testFindSchoolProficiencyByEditionWithoutSchoolLearning()
    {
        $school = $this->getSchoolMock();
        $provaBrasilEdition = new ProvaBrasilEdition(2, 2007);

        $result = $this->emSchool
            ->getRepository(School::class)
            ->findSchoolProficiencyByEdition($school, $provaBrasilEdition);

        $this->assertNull($result);
    }

    public function testFindSchoolProficiencyByEditionWithSchoolLearning()
    {
        $school = $this->getSchoolMock();
        $provaBrasilEdition = new ProvaBrasilEdition(6, 2015);

        $result = $this->emSchool
            ->getRepository(School::class)
            ->findSchoolProficiencyByEdition($school, $provaBrasilEdition);

        $this->assertEquals(142950, $result->getId());
        $this->assertEquals(6, $result->getEditionId());
        $this->assertEquals(113, $result->getStateId());
        $this->assertEquals(1597, $result->getCityId());
        $this->assertEquals(2, $result->getLocalizationId());
        $this->assertEquals(3, $result->getDependenceId());
    }

    private function getSchoolMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        $schoolMock->method('getId')
            ->willReturn(142950);

        return $schoolMock;
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->schoolLearningTableFixture = new SchoolLearningTableFixture();
        $this->schoolLearningTableFixture->createTable($kernel);
        $this->schoolLearningTableFixture->populateWithSchoolRegister();

        $this->emSchool = $this->schoolLearningTableFixture->getEntityManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->schoolLearningTableFixture->dropTable();
    }
}
