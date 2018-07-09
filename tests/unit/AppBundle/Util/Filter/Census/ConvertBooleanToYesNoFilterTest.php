<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Util\Filter\Census\ConvertBooleanToYesNoFilter;
use PHPUnit\Framework\TestCase;

class ConvertBooleanToYesNoFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $convertBooleanToYesNoFilter = new ConvertBooleanToYesNoFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $convertBooleanToYesNoFilter);
    }

    /**
     * @dataProvider convertBooleanToYesNoFilterDataProvider
     */
    public function testConvertBooleanToYesNoFilter($answer, $outputExpected)
    {
        $convertBooleanToYesNoFilter = new ConvertBooleanToYesNoFilter();
        $answer = $convertBooleanToYesNoFilter->translate($answer);

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

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $convertBooleanToYesNoFilter = new ConvertBooleanToYesNoFilter();
        $filters = $convertBooleanToYesNoFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
