<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemEdition;
use PHPUnit\Framework\TestCase;

class EnemEditionTest extends TestCase
{
    public function testGetYear()
    {
        $enem = new EnemEdition(2018);
        $year = $enem->getYear();

        $this->assertEquals(2018, $year);
    }
}
