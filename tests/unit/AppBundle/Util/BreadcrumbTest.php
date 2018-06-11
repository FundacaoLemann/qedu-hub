<?php

namespace Tests\Unit\AppBundle\Util\Filter;

use AppBundle\Util\Breadcrumb;
use PHPUnit\Framework\TestCase;

class BreadcrumbTest extends TestCase
{
    public function testBuildSchoolBreadcrumb()
    {
        $school = $this->getSchoolMock();
        $request = $this->getRequestStackMock();

        $breadcrumb = new Breadcrumb($request);
        $items = $breadcrumb->buildItems($school);

        $itemsExpected = $this->getSchoolItemsExpected();

        $this->assertEquals($itemsExpected, $items);
    }

    private function getSchoolMock()
    {
        $cityMock = $this->getCityMock();
        $stateMock = $this->getStateMock();

        $schoolMock = $this->createMock('AppBundle\Entity\School');
        $schoolMock->method('getId')
            ->willReturn(156485);

        $schoolMock->method('getName')
            ->willReturn('EE BELMIRO BRAGA');

        $schoolMock->method('getSlug')
            ->willReturn('ee-belmiro-braga');

        $schoolMock->method('getCity')
            ->willReturn($cityMock);

        $schoolMock->method('getState')
            ->willReturn($stateMock);

        return $schoolMock;
    }

    private function getCityMock()
    {
        $cityMock = $this->createMock('AppBundle\Entity\City');

        $cityMock->method('getId')
            ->willReturn(1597);

        $cityMock->method('getName')
            ->willReturn('Boa Esperança');

        $cityMock->method('getSlug')
            ->willReturn('boa-esperanca');

        return $cityMock;
    }

    private function getStateMock()
    {
        $stateMock = $this->createMock('AppBundle\Entity\State');

        $stateMock->method('getId')
            ->willReturn(113);

        $stateMock->method('getName')
            ->willReturn('Minas Gerais');

        $stateMock->method('getSlug')
            ->willReturn('minas-gerais');

        return $stateMock;
    }

    private function getRequestStackMock()
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $requestMock->method('getPathInfo')
            ->willReturn('/escola/156485-ee-belmiro-braga/sobre');

        $requestStackMock = $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
        $requestStackMock->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }

    private function getSchoolItemsExpected()
    {
        return [
            [
                'type' => 'country',
                'name' => 'Brasil',
                'url' => '/brasil/sobre',
                'element_id' => 'breadcrumb_country',
                'ajax_dropdown_url' => '',
                'search_text' => '',
                'placeholder' => '',
            ],
            [
                'type' => 'state',
                'name' => 'Minas Gerais',
                'url' => '/estado/113-minas-gerais/sobre',
                'element_id' => 'breadcrumb_state',
                'ajax_dropdown_url' => '/ajax/dropdown/remote/states/113/?url_default=/sobre',
                'search_text' => 'Carregando estados',
                'placeholder' => 'Busque por estado...',
            ],
            [
                'type' => 'city',
                'name' => 'Boa Esperança',
                'url' => '/cidade/1597-boa-esperanca/sobre',
                'element_id' => 'breadcrumb_city',
                'ajax_dropdown_url' => '/ajax/dropdown/remote/cities/113/1597?url_default=/sobre',
                'search_text' => 'Carregando munic\u00edpios',
                'placeholder' => 'Busque por cidade...',
            ],
            [
                'type' => 'school',
                'name' => 'EE BELMIRO BRAGA',
                'url' => '/escola/156485-ee-belmiro-braga/sobre',
                'element_id' => 'breadcrumb_school',
                'ajax_dropdown_url' => '/ajax/dropdown/remote/schools/113/1597?url_default=/sobre',
                'search_text' => 'Carregando escolas...',
                'placeholder' => 'Busque por escola...',
                'message_bottom_url' => '/busca/113-minas-gerais/1597-boa-esperanca',
            ]
        ];
    }
}
