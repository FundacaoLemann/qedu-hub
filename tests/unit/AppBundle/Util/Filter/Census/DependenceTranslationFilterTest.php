<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\Census\DependenceTranslationFilter;
use PHPUnit\Framework\TestCase;

class DependenceTranslationFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $dependenceTranslationFilter = new DependenceTranslationFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $dependenceTranslationFilter);
    }

    /**
     * @dataProvider dependenceTranslationFilterDataProvider
     */
    public function testDependenceTranslationFilter($dependenceId, $dependenceExpected)
    {
        $school = new School();
        $school->setDependenceId($dependenceId);

        $dependenceTranslationFilter = new DependenceTranslationFilter();
        $dependence = $dependenceTranslationFilter->translate($school);

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

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $dependenceTranslationFilter = new DependenceTranslationFilter();
        $filters = $dependenceTranslationFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
