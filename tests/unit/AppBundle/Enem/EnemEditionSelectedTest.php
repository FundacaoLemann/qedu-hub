<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemEdition;
use AppBundle\Enem\EnemEditionSelected;
use PHPUnit\Framework\TestCase;

class EnemEditionSelectedTest extends TestCase
{
    /**
     * @dataProvider getYearDataProvider
     */
    public function testGetYear($yearRequested, $expectedYear)
    {
        $requestStack = $this->getRequestStackMock($yearRequested);

        $census = new EnemEditionSelected($requestStack);
        $year = $census->getEnemEdition();

        $this->assertEquals($expectedYear, $year);
    }

    public function getYearDataProvider()
    {
        return [
            'valid_year_requested' => [
                2015,
                new EnemEdition(2015),
            ],
            'invalid_year_requested' => [
                'invalid_param',
                new EnemEdition(2017),
            ]
        ];
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
