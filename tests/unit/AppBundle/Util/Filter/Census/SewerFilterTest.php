<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Util\Filter\Census\SewerFilter;
use PHPUnit\Framework\TestCase;

class SewerFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $sewerFilter = new SewerFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $sewerFilter);
    }

    /**
     * @dataProvider sewerFilterDataProvider
     */
    public function testSewerFilter($servicesMock, $outputExpected)
    {
        $sewerFilter = new SewerFilter();
        $output = $sewerFilter->translate($servicesMock);

        $this->assertEquals($outputExpected, $output);
    }

    public function sewerFilterDataProvider()
    {
        return [
            [
                $method = $this->methodWillReturnTrue('hasPublicSewerSystem'),
                $outputExpected = 'Rede pública',
            ],
            [
                $method = $this->methodWillReturnTrue('hasSepticTank'),
                $outputExpected = 'Fossa',
            ],
            [
                $method = $this->methodWillReturnTrue('hasNotSewerSystem'),
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
        $sewerFilter = new SewerFilter();
        $filters = $sewerFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
