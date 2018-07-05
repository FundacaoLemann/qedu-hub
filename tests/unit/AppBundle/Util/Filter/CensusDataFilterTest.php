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
     * @dataProvider localizationTranslationFilterDataProvider
     */
    public function testLocalizationTranslationFilter($localizationId, $localizationExpected)
    {
        $school = new School();
        $school->setLocalizationId($localizationId);

        $censusDataFilter = new CensusDataFilter();
        $localization = $censusDataFilter->localizationTranslationFilter($school);

        $this->assertEquals($localizationExpected, $localization);
    }

    public function localizationTranslationFilterDataProvider()
    {
        return [
            [
                $localization = 1,
                $expected = 'Urbana',
            ],
            [
                $localization = 2,
                $expected = 'Rural',
            ],
            [
                $localization = 276756,
                $expected = '-',
            ],
        ];
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

    public function testGetFiltersShouldReturnAllFiltersRegistered()
    {
        $censusDataFilter = new CensusDataFilter();
        $filters = $censusDataFilter->getFilters();

        $this->assertCount(4, $filters);
    }
}
