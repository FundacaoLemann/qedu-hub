<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemSchoolRecord;
use AppBundle\Enem\EnemService;
use PHPUnit\Framework\TestCase;

class EnemSchoolRecordTest extends TestCase
{
    public function testGetEnemSchoolRecordShouldReturnSchoolParticipation()
    {
        $enemSchoolParticipation = $this->createMock('AppBundle\Entity\Enem\EnemSchoolParticipation');
        $enemSchoolResults = null;

        $enemSchoolRecord = new EnemSchoolRecord($enemSchoolParticipation, $enemSchoolResults);

        $this->assertInstanceOf(
            'AppBundle\Entity\Enem\EnemSchoolParticipation',
            $enemSchoolRecord->getEnemSchoolParticipation()
        );
    }

    public function testGetEnemSchoolRecordShouldReturnSchoolResults()
    {
        $enemSchoolParticipation = null;
        $enemSchoolResults = $this->createMock('AppBundle\Entity\Enem\EnemSchoolResults');

        $enemSchoolRecord = new EnemSchoolRecord($enemSchoolParticipation, $enemSchoolResults);

        $this->assertInstanceOf('AppBundle\Entity\Enem\EnemSchoolResults', $enemSchoolRecord->getEnemSchoolResults());
    }

    /**
     * @dataProvider enemDataProvider
     */
    public function testIsEnemRepresentative($participationRate, $participationCount, $expected)
    {
        $enemSchoolParticipation = $this->createMock('AppBundle\Entity\Enem\EnemSchoolParticipation');
        $enemSchoolParticipation->method('getParticipationRate')
            ->willReturn($participationRate);
        $enemSchoolParticipation->method('getParticipationCount')
            ->willReturn($participationCount);

        $enemSchoolResults = $this->createMock('AppBundle\Entity\Enem\EnemSchoolResults');

        $enemSchoolRecord = new EnemSchoolRecord($enemSchoolParticipation, $enemSchoolResults);

        $this->assertEquals($expected, $enemSchoolRecord->isRepresentative());
    }

    public function enemDataProvider()
    {
        return [
            ['0.34', 34, false],
            ['0.14', 1, false],
            ['0.6', 9, false],
            ['0.49', 11, false],
            ['0.51', 9, false],

            ['0.7', 50, true],
        ];
    }
}
