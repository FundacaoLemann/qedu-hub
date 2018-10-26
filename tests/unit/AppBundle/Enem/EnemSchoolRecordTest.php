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
}
