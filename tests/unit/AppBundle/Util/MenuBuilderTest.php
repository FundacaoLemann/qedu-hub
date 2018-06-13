<?php

namespace Tests\Unit\AppBundle\Util;

use AppBundle\Util\MenuBuilder;
use PHPUnit\Framework\TestCase;

class MenuBuilderTest extends TestCase
{
    /**
     * @dataProvider menuWithoutLearningSectionDataProvider
     */
    public function testBuildShouldReturnItemsWithoutLearningSection($itemsExpected)
    {
        $schoolProficiency = $this->getSchoolProficiencyMockWithoutProficiency();
        $request = $this->getRequestStackMockFromAboutUrl();
        $school = $this->getSchoolMock();

        $menu = new MenuBuilder($schoolProficiency, $request);
        $items = $menu->buildItems($school);

        $this->assertEquals(count($itemsExpected), count($items));
        $this->assertEquals($itemsExpected, $items);
    }

    public function menuWithoutLearningSectionDataProvider()
    {
        return [
            [
                [
                    [
                        'name' => 'Sobre a Escola',
                        'url' => '/escola/156485-ee-belmiro-braga/sobre',
                        'icon' => 'icon-page-about',
                        'isActive' => true,
                    ],
                    [
                        'name' => 'Enem',
                        'url' => '/escola/156485-ee-belmiro-braga/enem',
                        'icon' => 'icon-page-enem',
                        'isActive' => false,
                    ],
                ],
            ]
        ];
    }

    /**
     * @dataProvider menuWithLearningSectionDataProvider
     */
    public function testBuildShouldReturnItemsWithLearningSection($itemsExpected)
    {
        $schoolProficiency = $this->getSchoolProficiencyMockWithProficiency();
        $request = $this->getRequestStackMockFromCensusUrl();
        $school = $this->getSchoolMock();

        $menu = new MenuBuilder($schoolProficiency, $request);
        $items = $menu->buildItems($school);

        $this->assertEquals(count($itemsExpected), count($items));
        $this->assertEquals($itemsExpected, $items);
    }

    public function menuWithLearningSectionDataProvider()
    {
        return [
            [
                [
                    [
                        'name' => 'Aprendizado',
                        'url' => '/escola/156485-ee-belmiro-braga/aprendizado',
                        'icon' => 'icon-page-learning',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Compare',
                        'url' => '/escola/156485-ee-belmiro-braga/compare',
                        'icon' => 'icon-page-compare',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Evolução',
                        'url' => '/escola/156485-ee-belmiro-braga/evolucao',
                        'icon' => 'icon-page-evolution',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Proficiência',
                        'url' => '/escola/156485-ee-belmiro-braga/proficiencia',
                        'icon' => 'icon-page-proficiency',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Explore',
                        'url' => '/escola/156485-ee-belmiro-braga/explorar',
                        'icon' => 'icon-page-explore',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Pessoas',
                        'url' => '/escola/156485-ee-belmiro-braga/pessoas',
                        'icon' => 'icon-page-director',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Censo',
                        'url' => '/escola/156485-ee-belmiro-braga/censo-escolar',
                        'icon' => 'icon-page-census',
                        'isActive' => true,
                    ],
                    [
                        'name' => 'Ideb',
                        'url' => '/escola/156485-ee-belmiro-braga/ideb',
                        'icon' => 'icon-page-ideb',
                        'isActive' => false,
                    ],
                    [
                        'name' => 'Enem',
                        'url' => '/escola/156485-ee-belmiro-braga/enem',
                        'icon' => 'icon-page-enem',
                        'isActive' => false,
                    ],
                ],
            ],
        ];
    }

    private function getSchoolProficiencyMockWithoutProficiency()
    {
        $schoolProficiencyInterfaceMock = $this->createMock('AppBundle\Learning\ProficiencyInterface');
        $schoolProficiencyInterfaceMock->method('hasProficiencyInLastEdition')
            ->with($this->getSchoolMock())
            ->willReturn(false);

        return $schoolProficiencyInterfaceMock;
    }

    private function getSchoolProficiencyMockWithProficiency()
    {
        $schoolProficiencyInterfaceMock = $this->createMock('AppBundle\Learning\ProficiencyInterface');
        $schoolProficiencyInterfaceMock->method('hasProficiencyInLastEdition')
            ->with($this->getSchoolMock())
            ->willReturn(true);

        return $schoolProficiencyInterfaceMock;
    }

    private function getRequestStackMockFromAboutUrl()
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');

        $requestMock->method('getPathInfo')
            ->willReturn('/escola/156485-ee-belmiro-braga/sobre');

        $requestStackMock = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStackMock->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }

    private function getRequestStackMockFromCensusUrl()
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');

        $requestMock->method('getPathInfo')
            ->willReturn('/escola/156485-ee-belmiro-braga/censo-escolar');

        $requestStackMock = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStackMock->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }

    private function getSchoolMock()
    {
        $schoolMock = $this->createMock('AppBundle\Entity\School');

        $schoolMock->method('getId')
            ->willReturn(156485);

        $schoolMock->method('getSlug')
            ->willReturn('ee-belmiro-braga');

        return $schoolMock;
    }
}
