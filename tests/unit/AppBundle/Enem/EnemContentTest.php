<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemContent;
use AppBundle\Enem\EnemSchoolRecord;
use PHPUnit\Framework\TestCase;

class EnemContentTest extends TestCase
{
    public function testBuildShouldConstructFilter()
    {
        $filter = $this->createMock('AppBundle\Enem\EnemFilter');
        $service = $this->createMock('AppBundle\Enem\EnemService');

        $content = new EnemContent($filter, $service);

        $this->assertInstanceOf('AppBundle\Enem\EnemFilter', $content->getFilter());
    }

    public function testBuildShouldConstructEnemSchoolRecord()
    {
        $school = $this->createMock('AppBundle\Entity\School');

        $enemSchoolRecord = $this->createMock('AppBundle\Enem\EnemSchoolRecord');

        $service = $this->createMock('AppBundle\Enem\EnemService');
        $service->expects($this->once())
            ->method('getEnemByEdition')
            ->with($school)
            ->willReturn($enemSchoolRecord);

        $filter = $this->createMock('AppBundle\Enem\EnemFilter');

        $content = new EnemContent($filter, $service);
        $content->build($school);
        $actualEnemSchoolRecord = $content->getEnemSchoolRecord();

        $this->assertInstanceOf('AppBundle\Enem\EnemSchoolRecord', $actualEnemSchoolRecord);
    }
}
