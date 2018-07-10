<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Util\Filter\Census\GarbageFilter;
use PHPUnit\Framework\TestCase;

class GarbageFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $garbageFilter = new GarbageFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $garbageFilter);
    }

    /**
     * @dataProvider garbageFilterDataProvider
     */
    public function testGarbageFilter($servicesMock, $outputExpected)
    {
        $garbageFilter = new GarbageFilter();
        $output = $garbageFilter->translate($servicesMock);

        $this->assertEquals($outputExpected, $output);
    }

    public function garbageFilterDataProvider()
    {
        return [
            [
                $method = $this->methodWillReturnTrue('hasPeriodicGarbageCollection'),
                $outputExpected = 'Coleta periódica',
            ],
            [
                $method = $this->methodWillReturnTrue('hasBurnGarbage'),
                $outputExpected = 'Queima',
            ],
            [
                $method = $this->methodWillReturnTrue('hasTransferGarbageToOtherArea'),
                $outputExpected = 'Joga em outra área',
            ],
            [
                $method = $this->methodWillReturnTrue('hasWasteRecycling'),
                $outputExpected = 'Recicla',
            ],
            [
                $method = $this->methodWillReturnTrue('hasGarbageBuried'),
                $outputExpected = 'Enterra',
            ],
            [
                $method = $this->methodWillReturnTrue('hasOtherGarbageDestination'),
                $outputExpected = 'Outros',
            ],
            [
                $method = $this->createCensusServicesMock(),
                $outputExpected = 'Não informado',
            ],
        ];
    }

    private function methodWillReturnTrue($methodName)
    {
        $services = $this->createCensusServicesMock();
        $services->method($methodName)
            ->willReturn(true);

        return $services;
    }

    private function createCensusServicesMock()
    {
        return $this->createMock('AppBundle\Entity\Census\Group\Services');
    }

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $garbageFilter = new GarbageFilter();
        $filters = $garbageFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
