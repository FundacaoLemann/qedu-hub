<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemSchoolRecord;
use PHPUnit\Framework\TestCase;

class EnemSchoolRecordTest extends TestCase
{
    public function testGetEnemSchoolRecordShouldReturnSchoolParticipation()
    {
        $enemSchoolParticipation = $this->createMock('AppBundle\Entity\Enem\EnemSchoolParticipation');

        $enemSchoolRecord = new EnemSchoolRecord($enemSchoolParticipation);

        $this->assertInstanceOf('AppBundle\Entity\Enem\EnemSchoolParticipation', $enemSchoolRecord->getEnemSchoolParticipation());
    }
}
