<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Util\Filter\Census\OptionalNumberTranslationFilter;
use PHPUnit\Framework\TestCase;

class OptionalNumberTranslationFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $optionalNumberTranslationFilter = new OptionalNumberTranslationFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $optionalNumberTranslationFilter);
    }

    /**
     * @dataProvider optionalNumberTranslationFilterDataProvider
     */
    public function testOptionalNumberTranslationFilter($number, $numberExpected)
    {
        $optionalNumberTranslationFilter = new OptionalNumberTranslationFilter();
        $number = $optionalNumberTranslationFilter->optionalNumberTranslationFilter($number);

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

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $optionalNumberTranslationFilter = new OptionalNumberTranslationFilter();
        $filters = $optionalNumberTranslationFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
