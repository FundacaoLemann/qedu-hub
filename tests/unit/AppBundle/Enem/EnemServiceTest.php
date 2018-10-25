<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemEdition;
use AppBundle\Enem\EnemService;
use PHPUnit\Framework\TestCase;

class EnemServiceTest extends TestCase
{
    public function testEnemServiceShouldImplementsEnemServiceInterface()
    {
        $schoolRepository = $this->createMock('AppBundle\Repository\Enem\EnemSchoolRepositoryInterface');
        $enemEditionSelected = $this->createMock('AppBundle\Enem\EnemEditionSelected');

        $enemService = new EnemService($schoolRepository, $enemEditionSelected);

        $this->assertInstanceOf('AppBundle\Enem\EnemServiceInterface', $enemService);
    }

    public function testGetEnemByEditionShouldReturnEnemSchoolRecord()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $enemSchoolParticipationRepository = $this->getSchoolRepositoryMockWillReturn(
            $this->createMock('AppBundle\Entity\Enem\EnemSchoolParticipation')
        );
        $enemEditionSelected = $this->createMock('AppBundle\Enem\EnemEditionSelected');
        $enemEditionSelected->expects($this->once())
            ->method('getEnemEdition')
            ->willReturn(new EnemEdition(2017));

        $enemService = new EnemService($enemSchoolParticipationRepository, $enemEditionSelected);
        $enemSchoolRecord = $enemService->getEnemByEdition($school);

        $this->assertInstanceOf('AppBundle\Enem\EnemSchoolRecord', $enemSchoolRecord);
    }

    public function testGetEnemByEditionShouldReturnSchoolRecordWithoutEnemSchoolParticipation()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $enemSchoolParticipationRepository = $this->getSchoolRepositoryMockWillReturn(null);

        $enemEditionSelected = $this->createMock('AppBundle\Enem\EnemEditionSelected');
        $enemEditionSelected->expects($this->once())
            ->method('getEnemEdition')
            ->willReturn(new EnemEdition(2017));

        $enemService = new EnemService($enemSchoolParticipationRepository, $enemEditionSelected);
        $enemSchoolRecord = $enemService->getEnemByEdition($school);
        $enemSchoolParticipation = $enemSchoolRecord->getEnemSchoolParticipation();

        $this->assertNull($enemSchoolParticipation);
    }

    private function getSchoolRepositoryMockWillReturn($return)
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\Enem\EnemSchoolRepositoryInterface');
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
