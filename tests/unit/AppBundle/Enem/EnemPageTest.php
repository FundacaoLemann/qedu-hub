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

        $enemPage = new EnemPage($header, $schoolRepository);
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

        $enemPage = new EnemPage($header, $schoolRepository);
        $enemPage->build($schoolId);
    }
}
