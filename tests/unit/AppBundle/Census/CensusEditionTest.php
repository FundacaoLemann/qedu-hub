<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusEdition;
use PHPUnit\Framework\TestCase;

class CensusEditionTest extends TestCase
{
    public function testGetYear()
    {
        $census = new CensusEdition(2018);
        $year = $census->getYear();

        $this->assertEquals(2018, $year);
    }
}
