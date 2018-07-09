<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\Census\PhoneFilter;
use PHPUnit\Framework\TestCase;

class PhoneFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $phoneFilter = new PhoneFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $phoneFilter);
    }

    /**
     * @dataProvider phoneFilterDataProvider
     */
    public function testPhoneFilter($phone, $ddd, $phoneExpected)
    {
        $school = new School();
        $school->setPhone($phone);
        $school->setDdd($ddd);

        $phoneFilter = new PhoneFilter();
        $phone = $phoneFilter->phoneFilter($school);

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

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $phoneFilter = new PhoneFilter();
        $filters = $phoneFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
