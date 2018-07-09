<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\CensusDataFilter;
use PHPUnit\Framework\TestCase;

class CensusDataFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $censusDataFilter = new CensusDataFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $censusDataFilter);
    }

    /**
     * @dataProvider optionalNumberTranslationFilterDataProvider
     */
    public function testOptionalNumberTranslationFilter($number, $numberExpected)
    {
        $censusDataFilter = new CensusDataFilter();
        $number = $censusDataFilter->optionalNumberTranslationFilter($number);

        $this->assertEquals($numberExpected, $number);
    }

    public function optionalNumberTranslationFilterDataProvider()
    {
        return [
            [
                $localization = 329,
                $expected = 329,
            ],
            [
                $localization = null,
                $expected = '-',
            ],
        ];
    }

    /**
     * @dataProvider convertBooleanToYesNoFilterDataProvider
     */
    public function testConvertBooleanToYesNoFilter($answer, $outputExpected)
    {
        $censusDataFilter = new CensusDataFilter();
        $answer = $censusDataFilter->convertBooleanToYesNoFilter($answer);

        $this->assertEquals($outputExpected, $answer);
    }

    public function convertBooleanToYesNoFilterDataProvider()
    {
        return [
            [
                $answer = false,
                $outputExpected = "<span style='color: red'>Não</span>",
            ],
            [
                $answer = true,
                $outputExpected = "<span style='color: darkgreen'>Sim</span>",
            ],
            [
                $answer = null,
                $outputExpected = "<span style='color: #666'>Não informado</span>",
            ],
            [
                $answer = '',
                $outputExpected = "<span style='color: #666'>Não informado</span>",
            ],
        ];
    }

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

        $this->assertCount(3, $filters);
    }
}
