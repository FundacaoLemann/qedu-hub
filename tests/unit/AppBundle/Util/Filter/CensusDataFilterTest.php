<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\CensusDataFilter;
use PHPUnit\Framework\TestCase;

class CensusDataFilterTest extends TestCase
{   
    /**
     * @dataProvider waterSupplierFilterDataProvider
     */
    public function testWaterSupplierFilter($servicesMock, $outputExpected)
    {
        $censusDataFilter = new CensusDataFilter();
        $output = $censusDataFilter->waterSupplierFilter($servicesMock);

        $this->assertEquals($outputExpected, $output);
    }

    public function waterSupplierFilterDataProvider()
    {
        return [
            [
                $method = $this->methodWillReturnTrue('hasWaterPublicNetwork'),
                $outputExpected = 'Rede pública',
            ],
            [
                $method = $this->methodWillReturnTrue('hasArtesianWellWater'),
                $outputExpected = 'Poço artesiano',
            ],
            [
                $method = $this->methodWillReturnTrue('hasWaterReservoir'),
                $outputExpected = 'Cacimba',
            ],
            [
                $method = $this->methodWillReturnTrue('hasWaterRiver'),
                $outputExpected = 'Rio',
            ],
            [
                $method = $this->methodWillReturnTrue('hasNotWater'),
                $outputExpected = 'Inexistente',
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

    public function testGetFiltersShouldReturnAllFiltersRegistered()
    {
        $censusDataFilter = new CensusDataFilter();
        $filters = $censusDataFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
