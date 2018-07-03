<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusPage;
use AppBundle\Entity\Census\OperatingConditions;
use PHPUnit\Framework\TestCase;

class CensusPageTest extends TestCase
{
    public function testBuildShouldConstructHeader()
    {
        $school = $this->getActiveSchoolMock();

        $header = $this->createMock('AppBundle\Census\CensusHeader');
        $header->expects($this->once())
            ->method('build')
            ->with($school);
        $content = $this->createMock('AppBundle\Census\CensusContent');
        $schoolRepository = $this->getSchoolRepositoryMock($school);

        $schoolId = 1201;

        $censusPage = new CensusPage($header, $content, $schoolRepository);
        $censusPage->build($schoolId);

        $this->assertInstanceOf('AppBundle\Census\CensusHeader', $censusPage->getHeader());
    }

    public function testBuildShouldConstructContentWithSchoolData()
    {
        $school = $this->getActiveSchoolMock();

        $header = $this->createMock('AppBundle\Census\CensusHeader');
        $content = $this->createMock('AppBundle\Census\CensusContent');
        $content->expects($this->once())
            ->method('build')
            ->with($school);
        $schoolRepository = $this->getSchoolRepositoryMock($school);

        $schoolId = 1201;

        $censusPage = new CensusPage($header, $content, $schoolRepository);
        $censusPage->build($schoolId);

        $this->assertInstanceOf('AppBundle\Census\CensusContent', $censusPage->getContent());
    }

    public function testBuildShouldNotConstructContentWithInactiveSchool()
    {
        $school = $this->getExtinctSchoolMock();

        $header = $this->createMock('AppBundle\Census\CensusHeader');
        $content = $this->createMock('AppBundle\Census\CensusContent');
        $content->expects($this->never())
            ->method('build')
            ->with($school);
        $schoolRepository = $this->getSchoolRepositoryMock($school);

        $schoolId = 1201;

        $censusPage = new CensusPage($header, $content, $schoolRepository);
        $censusPage->build($schoolId);

        $this->assertInstanceOf('AppBundle\Census\CensusContent', $censusPage->getContent());
    }

    /**
     * @expectedException     \AppBundle\Exception\SchoolNotFoundException
     */
    public function testBuildShouldThrowSchoolNotFoundException()
    {
        $header = $this->createMock('AppBundle\Census\CensusHeader');
        $content = $this->createMock('AppBundle\Census\CensusContent');
        $schoolRepository = $this->getSchoolRepositoryMock($school = null);

        $schoolId = 1201;

        $censusPage = new CensusPage($header, $content, $schoolRepository);
        $censusPage->build($schoolId);
    }

    private function getSchoolRepositoryMock($schoolMock)
    {
        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolById')
            ->with($schoolId = 1201)
            ->willReturn($schoolMock);

        return $schoolRepository;
    }

    private function getActiveSchoolMock()
    {
        $school = $this->createMock('AppBundle\Entity\School');
        $school->method('getOperatingConditionsId')
            ->willReturn(OperatingConditions::ACTIVE);

        return $school;
    }

    private function getExtinctSchoolMock()
    {
        $school = $this->createMock('AppBundle\Entity\School');
        $school->method('getOperatingConditionsId')
            ->willReturn(OperatingConditions::EXTINCT_CURRENT_YEAR);

        return $school;
    }
}
