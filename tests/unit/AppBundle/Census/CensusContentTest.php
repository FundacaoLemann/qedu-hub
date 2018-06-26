<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusContent;
use PHPUnit\Framework\TestCase;

class CensusContentTest extends TestCase
{
    public function testBuildShouldConstructFilter()
    {
        $filter = $this->createMock('AppBundle\Census\CensusFilter');
        $censusService = $this->createMock('AppBundle\Census\CensusServiceInterface');
        $school = $this->createMock('AppBundle\Entity\School');

        $content = new CensusContent($filter, $censusService);
        $content->build($school);

        $this->assertInstanceOf('AppBundle\Census\CensusFilter', $content->getFilter());
    }

    public function testBuildShouldConstructCensusData()
    {
        $filter = $this->createMock('AppBundle\Census\CensusFilter');
        $censusService = $this->getCensusServiceMock();
        $school = $this->createMock('AppBundle\Entity\School');

        $content = new CensusContent($filter, $censusService);
        $content->build($school);

        $this->assertInstanceOf('AppBundle\Entity\Census\School', $content->getCensusData());
    }

    private function getCensusServiceMock()
    {
        $censusService = $this->createMock('AppBundle\Census\CensusServiceInterface');
        $censusService->expects($this->once())
            ->method('getCensusByEdition')
            ->with($this->createMock('AppBundle\Entity\School'))
            ->willReturn(
                $this->createMock('AppBundle\Entity\Census\School')
            );

        return $censusService;
    }
}
