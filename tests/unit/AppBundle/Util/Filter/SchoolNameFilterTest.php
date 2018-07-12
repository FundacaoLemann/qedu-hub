<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\SchoolNameFilter;
use PHPUnit\Framework\TestCase;

class SchoolNameFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $schoolNameFilter = new SchoolNameFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $schoolNameFilter);
    }

    /**
     * @dataProvider schoolNameFilterDataProvider
     */
    public function testSchoolNameFilter($namePrefix, $name, $nameStandard, $schoolNameExpected)
    {
        $school = new School();
        $school->setNamePrefix($namePrefix);
        $school->setName($name);
        $school->setNameStandard($nameStandard);

        $schoolNameFilter = new SchoolNameFilter();
        $schoolName = $schoolNameFilter->translate($school);

        $this->assertEquals($schoolNameExpected, $schoolName);
    }

    public function schoolNameFilterDataProvider()
    {
        return [
            [
                $namePrefix = '',
                $name = 'ALZIRA SALOMAO PROFESSORA',
                $nameStandard = 'ALZIRA SALOMAO PROFESSORA',
                $schoolNameExpected = 'Alzira Salomao Professora',
            ],
            [
                $namePrefix = 'EM',
                $name = 'ESCOLA MUNICIPAL JORGE',
                $nameStandard = 'JORGE',
                $schoolNameExpected = 'EM Jorge',
            ],
            [
                $namePrefix = 'EMEF',
                $name = 'ESCOLA MUL 03 DE JULHO',
                $nameStandard = '03 DE JULHO',
                $schoolNameExpected = 'EMEF 03 De Julho',
            ],
            [
                $namePrefix = 'ESCOLA',
                $name = 'ESC 13 DE DEZEMBRO',
                $nameStandard = '13 DE DEZEMBRO',
                $schoolNameExpected = 'Escola 13 De Dezembro',
            ],

            [
                $namePrefix = 'EE',
                $name = 'ESCOLA ESTADUAL 2 DE JULHO',
                $nameStandard = '2 DE JULHO',
                $schoolNameExpected = 'EE 2 De Julho',
            ],
            [
                $namePrefix = 'COLEGIO',
                $name = 'COL 4 DE DEZEMBRO',
                $nameStandard = '4 DE DEZEMBRO',
                $schoolNameExpected = 'Colegio 4 De Dezembro',
            ],
            [
                $namePrefix = 'COLEGIO',
                $name = 'ABC COLEGIO',
                $nameStandard = 'ABC',
                $schoolNameExpected = 'Colegio Abc',
            ],
            [
                $namePrefix = 'CRECHE',
                $name = 'CRECHE 15 DE NOVEMBRO II',
                $nameStandard = '15 DE NOVEMBRO II',
                $schoolNameExpected = 'Creche 15 De Novembro Ii',
            ],
        ];
    }

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $schoolNameFilter = new SchoolNameFilter();
        $filters = $schoolNameFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
