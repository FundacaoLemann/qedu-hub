<?php

namespace Tests\Integration\AppBundle\Repository\Enem;

use AppBundle\Entity\Enem\EnemSchoolResults;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Fixture\Database\EnemSchoolResultsTableFixture;

class EnemSchoolResultsRepositoryTest extends KernelTestCase
{
    private $enemSchoolResultsTableFixture;
    private $emEnemResults;

    public function testFindEnemSchoolResultsByEnemSchoolParticipation()
    {
        $enemSchoolParticipation = $this->createMock('AppBundle\Entity\Enem\EnemSchoolParticipation');
        $enemSchoolParticipation->method('getId')
            ->willReturn(179925);

        $schoolResults = $this->emEnemResults
            ->getRepository(EnemSchoolResults::class)
            ->findEnemSchoolResultsByEnemSchoolParticipation($enemSchoolParticipation);

        $expectedAverageHumanSciences = 502.37;
        $expectedAverageNaturalSciences = 440.66;
        $expectedAverageLanguagesAndCodes = 493.01;
        $expectedAverageMath = 451.77;
        $expectedAverageEssay = 441.82;

        $this->assertEquals($expectedAverageHumanSciences, $schoolResults->getHumanSciencesAverage());
        $this->assertEquals($expectedAverageNaturalSciences, $schoolResults->getNaturalSciencesAverage());
        $this->assertEquals($expectedAverageLanguagesAndCodes, $schoolResults->getLanguagesAndCodesAverage());
        $this->assertEquals($expectedAverageMath, $schoolResults->getMathematicsAverage());
        $this->assertEquals($expectedAverageEssay, $schoolResults->getEssayAverage());
    }

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->enemSchoolResultsTableFixture = new EnemSchoolResultsTableFixture();
        $this->enemSchoolResultsTableFixture->createTable($kernel);
        $this->enemSchoolResultsTableFixture->populateWithEnemSchoolResultsRegister();

        $this->emEnemResults = $this->enemSchoolResultsTableFixture->getEntityManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->enemSchoolResultsTableFixture->dropTable();
    }
}
