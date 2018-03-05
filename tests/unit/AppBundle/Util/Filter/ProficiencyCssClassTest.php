<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Util\Filter\ProficiencyCssClass;
use PHPUnit\Framework\TestCase;

class ProficiencyCssClassTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $proficiencyCssClass = new ProficiencyCssClass();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $proficiencyCssClass);
    }

    /**
     * @dataProvider proficiencyCssClassDataProvider
     */
    public function testProficiencyCssClassFilter($percentage, $cssClassExpected)
    {
        $proficiencyCssClass = new ProficiencyCssClass();
        $cssClass = $proficiencyCssClass->proficiencyCssClassFilter($percentage);

        $this->assertEquals($cssClassExpected, $cssClass);
    }

    public function proficiencyCssClassDataProvider()
    {
        return [
            [
                'percentage' => 0,
                'cssClassExpected' => 'optimal-decile-bg-0'
            ],
            [
                'percentage' => 4,
                'cssClassExpected' => 'optimal-decile-bg-1'
            ],
            [
                'percentage' => 7,
                'cssClassExpected' => 'optimal-decile-bg-1'
            ],
            [
                'percentage' => 23,
                'cssClassExpected' => 'optimal-decile-bg-2'
            ],
            [
                'percentage' => 78,
                'cssClassExpected' => 'optimal-decile-bg-7'
            ],
            [
                'percentage' => 93,
                'cssClassExpected' => 'optimal-decile-bg-9'
            ],
            [
                'percentage' => 100,
                'cssClassExpected' => 'optimal-decile-bg-10'
            ],
        ];
    }

    public function testGetFiltersShouldReturnTwigFilter()
    {
        $proficiencyCssClass = new ProficiencyCssClass();
        $filter = $proficiencyCssClass->getFilters()[0];

        $callable = $filter->getCallable();

        $this->assertEquals('proficiencyCssClass', $filter->getName());
        $this->assertEquals('proficiencyCssClassFilter', $callable[1]);
        $this->assertInstanceOf('AppBundle\Util\Filter\ProficiencyCssClass', $callable[0]);
    }
}
