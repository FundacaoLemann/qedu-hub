<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\Census\AddressFilter;
use PHPUnit\Framework\TestCase;

class AddressFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $addressFilter = new AddressFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $addressFilter);
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

        $addressFilter = new AddressFilter();
        $address = $addressFilter->addressFilter($school);

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

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $addressFilter = new AddressFilter();
        $filters = $addressFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
