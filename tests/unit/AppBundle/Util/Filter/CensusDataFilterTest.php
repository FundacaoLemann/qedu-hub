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
     * @dataProvider dependenceTranslationFilterDataProvider
     */
    public function testDependenceTranslationFilter($dependenceId, $dependenceExpected)
    {
        $school = new School();
        $school->setDependenceId($dependenceId);

        $censusDataFilter = new CensusDataFilter();
        $dependence = $censusDataFilter->dependenceTranslationFilter($school);

        $this->assertEquals($dependenceExpected, $dependence);
    }

    public function dependenceTranslationFilterDataProvider()
    {
        return [
            [
                $localization = 0,
                $expected = 'Todas',
            ],
            [
                $localization = 1,
                $expected = 'Federal',
            ],
            [
                $localization = 2,
                $expected = 'Estadual',
            ],
            [
                $localization = 3,
                $expected = 'Municipal',
            ],
            [
                $localization = 4,
                $expected = 'Privada',
            ],
            [
                $localization = 25555565,
                $expected = '-',
            ],
        ];
    }

    /**
     * @dataProvider phoneFilterDataProvider
     */
    public function testPhoneFilter($phone, $ddd, $phoneExpected)
    {
        $school = new School();
        $school->setPhone($phone);
        $school->setDdd($ddd);

        $censusDataFilter = new CensusDataFilter();
        $phone = $censusDataFilter->phoneFilter($school);

        $this->assertEquals($phoneExpected, $phone);
    }

    public function phoneFilterDataProvider()
    {
        return [
            [
                $phone = 32246129,
                $ddd = 68,
                $expected = '(68) 3224-6129',
            ],
            [
                $phone = null,
                $ddd = 68,
                $expected = 'Não informado',
            ],
            [
                $phone = null,
                $ddd = null,
                $expected = 'Não informado',
            ],
        ];
    }

    /**
     * @dataProvider addressFilterDataProvider
     */
    public function testAddressFilter($address, $district, $cep, $addressExpected)
    {
        $school = new School();
        $school->setAddress($address);
        $school->setDistrict($district);
        $school->setAddressCep($cep);

        $censusDataFilter = new CensusDataFilter();
        $address = $censusDataFilter->addressFilter($school);

        $this->assertEquals($addressExpected, $address);
    }

    public function addressFilterDataProvider()
    {
        return [
            [
                $address = null,
                $district = '',
                $cep = '',
                $addressExpected = 'Não informado',
            ],
            [
                $address = 'RUA CARLINDO PEREIRA DA COSTA',
                $district = null,
                $cep = '13601008',
                $addressExpected = 'RUA CARLINDO PEREIRA DA COSTA<br/>CEP: 13601008',
            ],
            [
                $address = 'RUA CARLINDO PEREIRA DA COSTA',
                $district = 'VILA MICHELIM',
                $cep = null,
                $addressExpected = 'RUA CARLINDO PEREIRA DA COSTA<br/>Bairro: VILA MICHELIM',
            ],
            [
                $address = 'RUA CARLINDO PEREIRA DA COSTA',
                $district = 'VILA MICHELIM',
                $cep = '13601008',
                $addressExpected = 'RUA CARLINDO PEREIRA DA COSTA<br/>Bairro: VILA MICHELIM<br/>CEP: 13601008',
            ],
        ];
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

        $this->assertCount(7, $filters);
    }
}
