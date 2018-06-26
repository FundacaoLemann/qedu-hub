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
        $requestStack = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');

        $censusService = new CensusService($schoolRepository, $requestStack);

        $this->assertInstanceOf('AppBundle\Census\CensusServiceInterface', $censusService);
    }

    public function testGetCensusByEditionShouldReturnCensusData()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\Census\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolCensusByEdition')
            ->with(
                $this->equalTo($school),
                $this->equalTo(new CensusEdition(2017))
            )
            ->willReturn($this->createMock('AppBundle\Entity\Census\School'));

        $request = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $request->method('get')
            ->with('year')
            ->willReturn($selectedYear = 2017);
        $requestStack = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStack->method('getCurrentRequest')
            ->willReturn($request);

        $censusService = new CensusService($schoolRepository, $requestStack);
        $school = $censusService->getCensusByEdition($school);

        $this->assertInstanceOf('AppBundle\Entity\Census\School', $school);
    }

    public function testGetCensusByEditionShouldNotReturnData()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\Census\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolCensusByEdition')
            ->with(
                $this->equalTo($school),
                $this->equalTo(new CensusEdition(2017))
            )
            ->willReturn(null);

        $request = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $request->method('get')
            ->with('year')
            ->willReturn($selectedYear = 2017);
        $requestStack = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStack->method('getCurrentRequest')
            ->willReturn($request);

        $censusService = new CensusService($schoolRepository, $requestStack);
        $schoolCensus = $censusService->getCensusByEdition($school);

        $this->assertNull($schoolCensus);
    }
}
