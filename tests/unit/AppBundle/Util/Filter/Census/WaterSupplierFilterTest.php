<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Util\Filter\Census\WaterSupplierFilter;
use PHPUnit\Framework\TestCase;

class WaterSupplierFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $waterSupplierFilter = new WaterSupplierFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $waterSupplierFilter);
    }

    /**
     * @dataProvider waterSupplierFilterDataProvider
     */
    public function testWaterSupplierFilter($servicesMock, $outputExpected)
    {
        $waterSupplierFilter = new WaterSupplierFilter();
        $output = $waterSupplierFilter->waterSupplierFilter($servicesMock);

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

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $waterSupplierFilter = new WaterSupplierFilter();
        $filters = $waterSupplierFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
