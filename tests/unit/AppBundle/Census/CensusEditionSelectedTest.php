<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusEdition;
use AppBundle\Census\CensusEditionSelected;
use PHPUnit\Framework\TestCase;

class CensusEditionSelectedTest extends TestCase
{
    /**
     * @dataProvider getYearDataProvider
     */
    public function testGetYear($yearRequested, $expectedYear)
    {
        $requestStack = $this->getRequestStackMock($yearRequested);

        $census = new CensusEditionSelected($requestStack);
        $year = $census->getCensusEdition();

        $this->assertEquals($expectedYear, $year);
    }

    public function getYearDataProvider()
    {
        return [
            'valid_year_requested' => [
                2015,
                new CensusEdition(2015),
            ],
            'invalid_year_requested' => [
                'invalid_param',
                new CensusEdition(2018),
            ]
        ];
    }

    private function getRequestStackMock($valueRequested)
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $requestMock->expects($this->once())
            ->method('get')
            ->with('year', $defaultYear = 2018)
            ->willReturn($valueRequested);

        $requestStackMock = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStackMock->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }
}
