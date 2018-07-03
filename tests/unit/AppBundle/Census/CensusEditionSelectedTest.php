<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusEdition;
use AppBundle\Census\CensusEditionSelected;
use PHPUnit\Framework\TestCase;

class CensusEditionSelectedTest extends TestCase
{
    public function testGetYearWithValidYearRequested()
    {
        $requestStack = $this->getRequestStackMock(2015);

        $census = new CensusEditionSelected($requestStack);
        $year = $census->getCensusEdition();

        $expectedYear = new CensusEdition(2015);

        $this->assertEquals($expectedYear, $year);
    }

    public function testGetYearWithInvalidYearRequested()
    {
        $requestStack = $this->getRequestStackMock('invalid_param');

        $census = new CensusEditionSelected($requestStack);
        $year = $census->getCensusEdition();

        $expectedDefaultYear = new CensusEdition(2017);

        $this->assertEquals($expectedDefaultYear, $year);
    }

    private function getRequestStackMock($valueRequested)
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $requestMock->expects($this->once())
            ->method('get')
            ->with('year', $defaultYear = 2017)
            ->willReturn($valueRequested);

        $requestStackMock = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStackMock->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }
}
