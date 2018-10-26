<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemEdition;
use AppBundle\Enem\EnemService;
use PHPUnit\Framework\TestCase;

class EnemServiceTest extends TestCase
{
    public function testEnemServiceShouldImplementsEnemServiceInterface()
    {
        $enemSchoolParticipationRepository = $this->createMock(
            'AppBundle\Repository\Enem\EnemSchoolParticipationRepositoryInterface'
        );
        $enemSchoolResultsRepository = $this->createMock(
            'AppBundle\Repository\Enem\EnemSchoolResultsRepositoryInterface'
        );
        $enemEditionSelected = $this->createMock('AppBundle\Enem\EnemEditionSelected');

        $enemService = new EnemService(
            $enemSchoolParticipationRepository,
            $enemSchoolResultsRepository,
            $enemEditionSelected
        );

        $this->assertInstanceOf('AppBundle\Enem\EnemServiceInterface', $enemService);
    }

    public function testGetEnemByEditionShouldReturnEnemSchoolRecord()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $enemSchoolParticipationRepository = $this->getEnemSchoolParticipationRepositoryMockWillReturn(
            $this->createMock('AppBundle\Entity\Enem\EnemSchoolParticipation')
        );
        $enemEditionSelected = $this->createMock('AppBundle\Enem\EnemEditionSelected');
        $enemEditionSelected->expects($this->once())
            ->method('getEnemEdition')
            ->willReturn(new EnemEdition(2017));

        $enemSchoolResultsRepository = $this->createMock(
            'AppBundle\Repository\Enem\EnemSchoolResultsRepositoryInterface'
        );

        $enemService = new EnemService(
            $enemSchoolParticipationRepository,
            $enemSchoolResultsRepository,
            $enemEditionSelected
        );
        $enemSchoolRecord = $enemService->getEnemByEdition($school);

        $this->assertInstanceOf('AppBundle\Enem\EnemSchoolRecord', $enemSchoolRecord);
    }

    public function testGetEnemByEditionShouldReturnSchoolRecordWithoutEnemSchoolParticipation()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $enemSchoolParticipationRepository = $this->getEnemSchoolParticipationRepositoryMockWillReturn(null);

        $enemEditionSelected = $this->createMock('AppBundle\Enem\EnemEditionSelected');
        $enemEditionSelected->expects($this->once())
            ->method('getEnemEdition')
            ->willReturn(new EnemEdition(2017));

        $enemSchoolResultsRepository = $this->createMock(
            'AppBundle\Repository\Enem\EnemSchoolResultsRepositoryInterface'
        );

        $enemService = new EnemService(
            $enemSchoolParticipationRepository,
            $enemSchoolResultsRepository,
            $enemEditionSelected
        );
        $enemSchoolRecord = $enemService->getEnemByEdition($school);
        $enemSchoolParticipation = $enemSchoolRecord->getEnemSchoolParticipation();

        $this->assertNull($enemSchoolParticipation);
    }

    private function getEnemSchoolParticipationRepositoryMockWillReturn($return)
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\Enem\EnemSchoolParticipationRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findEnemSchoolParticipationByEdition')
            ->with(
                $this->equalTo($school),
                $this->equalTo(new EnemEdition(2017))
            )
            ->willReturn($return);

        return $schoolRepository;
    }
}
