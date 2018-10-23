<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemPage;
use PHPUnit\Framework\TestCase;

class EnemPageTest extends TestCase
{
    public function testBuildShouldConstructHeader()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolById')
            ->with($schoolId = 1201)
            ->willReturn($school);

        $header = $this->createMock('AppBundle\Component\Header');
        $header->expects($this->once())
            ->method('build');

        $content = $this->createMock('AppBundle\Enem\EnemContent');

        $enemPage = new EnemPage($header, $schoolRepository, $content);
        $enemPage->build($schoolId);

        $this->assertInstanceOf('AppBundle\Component\Header', $enemPage->getHeader());
    }

    /**
     * @expectedException \AppBundle\Exception\SchoolNotFoundException
     */
    public function testBuildShouldThrowSchoolNotFoundException()
    {
        $header = $this->createMock('AppBundle\Component\Header');

        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolById')
            ->with($schoolId = 9)
            ->willReturn(null);

        $content = $this->createMock('AppBundle\Enem\EnemContent');

        $enemPage = new EnemPage($header, $schoolRepository, $content);
        $enemPage->build($schoolId);
    }

    public function testBuildShouldConstructContent()
    {
        $school = $this->createMock('AppBundle\Entity\School');
        $schoolRepository = $this->createMock('AppBundle\Repository\SchoolRepositoryInterface');
        $schoolRepository->expects($this->once())
            ->method('findSchoolById')
            ->with($schoolId = 1201)
            ->willReturn($school);

        $header = $this->createMock('AppBundle\Component\Header');

        $content = $this->createMock('AppBundle\Enem\EnemContent');
        $content->expects($this->once())
            ->method('build')
            ->with($school);

        $enemPage = new EnemPage($header, $schoolRepository, $content);
        $enemPage->build($schoolId);

        $this->assertInstanceOf('AppBundle\Enem\EnemContent', $enemPage->getContent());
    }
}
