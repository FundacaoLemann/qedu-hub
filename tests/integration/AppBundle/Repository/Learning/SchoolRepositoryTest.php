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

    /**
     * @dataProvider findSchoolProficiencyByEditionDataProvider
     */
    public function testFindSchoolProficiencyByEdition($school, $provaBrasilEdition, $resultExpected)
    {
        $result = $this->emSchool
            ->getRepository(School::class)
            ->findSchoolProficiencyByEdition($school, $provaBrasilEdition);

        $this->assertEquals($resultExpected, count($result));
    }

    public function findSchoolProficiencyByEditionDataProvider()
    {
        return [
            'with_school_learning' => [
                $this->getSchoolMock(),
                new ProvaBrasilEdition(6, 2015),
                $schoolsFound = 1,
            ],
            'without_school_learning' => [
                $this->getSchoolMock(),
                new ProvaBrasilEdition(2, 2007),
                $schoolsFound = 0,
            ],
        ];
    }

    private function getSchoolMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        $schoolMock->method('getId')
            ->willReturn(258542);

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
