<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Util\Filter\Census\PowerSupplierFilter;
use PHPUnit\Framework\TestCase;

class PowerSupplierFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $powerSupplierFilter = new PowerSupplierFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $powerSupplierFilter);
    }

    /**
     * @dataProvider powerSupplierFilterDataProvider
     */
    public function testPowerSupplierFilter($servicesMock, $outputExpected)
    {
        $powerSupplierFilter = new PowerSupplierFilter();
        $output = $powerSupplierFilter->translate($servicesMock);

        $this->assertEquals($outputExpected, $output);
    }

    public function powerSupplierFilterDataProvider()
    {
        return [
            [
                $method = $this->methodWillReturnTrue('hasPublicNetworkPower'),
                $outputExpected = 'Rede pública',
            ],
            [
                $method = $this->methodWillReturnTrue('hasGeneratorPower'),
                $outputExpected = 'Gerador',
            ],
            [
                $method = $this->methodWillReturnTrue('hasPowerFromOthersSources'),
                $outputExpected = 'Outros',
            ],
            [
                $method = $this->methodWillReturnTrue('hasNotEnergy'),
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
        $powerSupplierFilter = new PowerSupplierFilter();
        $filters = $powerSupplierFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
