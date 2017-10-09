<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\ProvaBrasilEdition;
use PHPUnit\Framework\TestCase;

class ProvaBrasilEditionTest extends TestCase
{
    private $provaBrasil;

    protected function setUp()
    {
        $this->provaBrasil = new ProvaBrasilEdition(6, 2015);
    }

    protected function tearDown()
    {
        $this->provaBrasil = null;
    }

    public function testGetYear()
    {
        $year = $this->provaBrasil->getYear();

        $yearExpected = 2015;

        $this->assertEquals($yearExpected, $year);
    }

    public function testGetCode()
    {
        $code = $this->provaBrasil->getCode();

        $codeExpected = 6;

        $this->assertEquals($codeExpected, $code);
    }
}