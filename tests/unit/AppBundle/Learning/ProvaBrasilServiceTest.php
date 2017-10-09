<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\ProvaBrasilEdition;
use AppBundle\Learning\ProvaBrasilService;
use PHPUnit\Framework\TestCase;

class ProvaBrasilServiceTest extends TestCase
{
    private $provaBrasilService;

    protected function setUp()
    {
        $this->provaBrasilService = new ProvaBrasilService();
    }

    protected function tearDown()
    {
        $this->provaBrasilService = null;
    }

    public function testGetLastEdition()
    {
        $provaBrasil = $this->provaBrasilService->getLastEdition();

        $provaBrasilExpected = new ProvaBrasilEdition(6, 2015);

        $this->assertEquals($provaBrasilExpected, $provaBrasil);
    }
}
