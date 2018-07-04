<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusEdition;
use AppBundle\Census\CensusService;
use PHPUnit\Framework\TestCase;

class CensusServiceTest extends TestCase
{
    public function testCensusServiceShouldImplementsCensusServiceInterface()
    {
        $schoolRepository = $this->createMock('AppBundle\Repository\Census\SchoolRepositoryInterface');
        $censusEditionSelected = $this->createMock('AppBundle\Census\CensusEditionSelected');

        $censusService = new CensusService($schoolRepository, $censusEditionSelected);

        $this->assertInstanceOf('AppBundle\Census\CensusServiceInterface', $censusService);
    }

    public function testGetCensusByEditionShouldReturnCensusData()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->getSchoolRepositoryMockWillReturn(
            $this->createMock('AppBundle\Entity\Census\School')
        );
        $censusEditionSelected = $this->getCensusEditionSelectedMock();

        $censusService = new CensusService($schoolRepository, $censusEditionSelected);
        $school = $censusService->getCensusByEdition($school);

        $this->assertInstanceOf('AppBundle\Entity\Census\School', $school);
    }

    public function testGetCensusByEditionShouldNotReturnData()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->getSchoolRepositoryMockWillReturn(null);
        $censusEditionSelected = $this->getCensusEditionSelectedMock();

        $censusService = new CensusService($schoolRepository, $censusEditionSelected);
        $schoolCensus = $censusService->getCensusByEdition($school);

        $this->assertNull($schoolCensus);
    }

    private function getSchoolRepositoryMockWillReturn($return)
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\Census\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolCensusByEdition')
            ->with(
                $this->equalTo($school),
                $this->equalTo(new CensusEdition(2017))
            )
            ->willReturn($return);

        return $schoolRepository;
    }

    private function getCensusEditionSelectedMock()
    {
        $censusEditionSelected = $this->createMock('AppBundle\Census\CensusEditionSelected');
        $censusEditionSelected->expects($this->once())
            ->method('getCensusEdition')
            ->willReturn(new CensusEdition(2017));

        return $censusEditionSelected;
    }
}
