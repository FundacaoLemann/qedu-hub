<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;

class Breadcrumb
{
    use RequestSegmentTrait;

    private $entity;
    private $request;
    private $lastUrlSegment;

    public function __construct($entity, Request $request)
    {
        $this->entity = $entity;
        $this->request = $request;
    }

    public function getItems()
    {
        $pathInfo = $this->request->getPathInfo();
        $this->lastUrlSegment = $this->getLastUrlSegment($pathInfo);

        return [
            $this->getCountryConfiguration(),
            $this->getStateConfiguration(),
            $this->getCityConfiguration(),
            $this->getSchoolConfiguration(),
        ];
    }

    private function getCountryConfiguration()
    {
        return [
            'type' => 'country',
            'name' => 'Brasil',
            'url' => sprintf('/brasil/%s', $this->lastUrlSegment),
            'element_id' => 'breadcrumb_country',
            'ajax_dropdown_url' => '',
            'search_text' => '',
            'placeholder' => '',
        ];
    }

    private function getStateConfiguration()
    {
        $state = $this->entity->getState();

        return [
            'type' => 'state',
            'name' => $state->getName(),
            'url' => sprintf(
                '/estado/%s-%s/%s',
                $state->getId(),
                $state->getSlug(),
                $this->lastUrlSegment
            ),
            'element_id' => 'breadcrumb_state',
            'ajax_dropdown_url' => sprintf(
                '/ajax/dropdown/remote/states/%s/?url_default=/%s',
                $state->getId(),
                $this->lastUrlSegment
            ),
            'search_text' => 'Carregando estados',
            'placeholder' => 'Busque por estado...',
        ];
    }

    private function getCityConfiguration()
    {
        $state = $this->entity->getState();
        $city = $this->entity->getCity();

        return [
            'type' => 'city',
            'name' => $city->getName(),
            'url' => sprintf(
                '/cidade/%s-%s/%s',
                $city->getId(),
                $city->getSlug(),
                $this->lastUrlSegment
            ),
            'element_id' => 'breadcrumb_city',
            'ajax_dropdown_url' => sprintf(
                '/ajax/dropdown/remote/cities/%s/%s?url_default=/%s',
                $state->getId(),
                $city->getId(),
                $this->lastUrlSegment
            ),
            'search_text' => 'Carregando munic\u00edpios',
            'placeholder' => 'Busque por cidade...',
        ];
    }

    private function getSchoolConfiguration()
    {
        $state = $this->entity->getState();
        $city = $this->entity->getCity();

        return [
            'type' => 'school',
            'name' => $this->entity->getName(),
            'url' => sprintf(
                '/escola/%s-%s/%s',
                $this->entity->getId(),
                $this->entity->getSlug(),
                $this->lastUrlSegment
            ),
            'element_id' => 'breadcrumb_school',
            'ajax_dropdown_url' => sprintf(
                '/ajax/dropdown/remote/schools/%s/%s?url_default=/%s',
                $state->getId(),
                $city->getId(),
                $this->lastUrlSegment
            ),
            'search_text' => 'Carregando escolas...',
            'placeholder' => 'Busque por escola...',
            'message_bottom_url' => sprintf(
                '/busca/%s-%s/%s-%s',
                $state->getId(),
                $state->getSlug(),
                $city->getId(),
                $city->getSlug()
            ),
        ];
    }
}
