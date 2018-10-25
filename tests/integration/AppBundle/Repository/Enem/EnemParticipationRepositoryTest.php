<?php

namespace Tests\Integration\AppBundle\Repository\Enem;

use AppBundle\Entity\Enem\EnemSchoolParticipation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Fixture\Database\EducationEntityTableFixture;
use Tests\Fixture\Database\EnemSchoolParticipationTableFixture;

class EnemParticipationRepositoryTest extends KernelTestCase
{
    private $enemSchoolParticipationTableFixture;
    private $educationEntityTableFixture;
    private $emEnemParticipation;

    public function testFindEnemSchoolParticipationByEdition()
    {
        $school = $this->getSchoolMock();

        $enemEdition = $this->createMock('AppBundle\Enem\EnemEdition');
        $enemEdition->method('getYear')
            ->willReturn(2017);

        $schoolParticipation = $this->emEnemParticipation
            ->getRepository(EnemSchoolParticipation::class)
            ->findEnemSchoolParticipationByEdition($school, $enemEdition);

        $participationCountExpected = 31;
        $participationRateExpected = '0.7209';

        $this->assertEquals($participationCountExpected, $schoolParticipation->getParticipationCount());
        $this->assertEquals($participationRateExpected, $schoolParticipation->getParticipationRate());
    }

    private function getSchoolMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        $schoolMock->method('getId')
            ->willReturn(212104);

        return $schoolMock;
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->educationEntityTableFixture = new EducationEntityTableFixture();
        $this->educationEntityTableFixture->createTable($kernel);
        $this->educationEntityTableFixture->populateWithEducationEntityRegister();

        $this->enemSchoolParticipationTableFixture = new EnemSchoolParticipationTableFixture();
        $this->enemSchoolParticipationTableFixture->loadEntityManager($kernel);
        $this->enemSchoolParticipationTableFixture->createEnemSchoolParticipationTable();
        $this->enemSchoolParticipationTableFixture->populateWithEnemSchoolParticipationRegister();

        $this->emEnemParticipation = $this->enemSchoolParticipationTableFixture->getEntityManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->enemSchoolParticipationTableFixture->dropTable();
    }
}
