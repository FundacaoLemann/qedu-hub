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
                $dependence = 0,
                $expected = 'Todas',
            ],
            [
                $dependence = 1,
                $expected = 'Federal',
            ],
            [
                $dependence = 2,
                $expected = 'Estadual',
            ],
            [
                $dependence = 3,
                $expected = 'Municipal',
            ],
            [
                $dependence = 4,
                $expected = 'Privada',
            ],
            [
                $dependence = 25555565,
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
