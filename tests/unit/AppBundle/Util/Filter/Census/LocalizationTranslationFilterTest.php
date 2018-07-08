<?php

namespace Tests\Unit\AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use AppBundle\Util\Filter\Census\LocalizationTranslationFilter;
use PHPUnit\Framework\TestCase;

class LocalizationTranslationFilterTest extends TestCase
{
    public function testClassShouldBeInstanceOfAbstractExtension()
    {
        $localizationTranslationFilter = new LocalizationTranslationFilter();

        $this->assertInstanceOf('Twig\Extension\AbstractExtension', $localizationTranslationFilter);
    }

    /**
     * @dataProvider localizationTranslationFilterDataProvider
     */
    public function testLocalizationTranslationFilter($localizationId, $localizationExpected)
    {
        $school = new School();
        $school->setLocalizationId($localizationId);

        $localizationTranslationFilter = new LocalizationTranslationFilter();
        $localization = $localizationTranslationFilter->localizationTranslationFilter($school);

        $this->assertEquals($localizationExpected, $localization);
    }

    public function localizationTranslationFilterDataProvider()
    {
        return [
            [
                $localization = 1,
                $expected = 'Urbana',
            ],
            [
                $localization = 2,
                $expected = 'Rural',
            ],
            [
                $localization = 276756,
                $expected = '-',
            ],
        ];
    }

    public function testGetFiltersShouldReturnFilterRegistered()
    {
        $localizationTranslationFilter = new LocalizationTranslationFilter();
        $filters = $localizationTranslationFilter->getFilters();

        $this->assertCount(1, $filters);
    }
}
