<?php

namespace AppBundle\Component;

use AppBundle\Util\RequestSegmentTrait;
use Symfony\Component\HttpFoundation\RequestStack;

class Breadcrumb
{
    use RequestSegmentTrait;

    private $lastUrlSegment;
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function buildItems($entity)
    {
        $pathInfo = $this->request->getPathInfo();
        $this->lastUrlSegment = $this->getLastUrlSegment($pathInfo);

        return [
            $this->getCountryConfiguration(),
            $this->getStateConfiguration($entity),
            $this->getCityConfiguration($entity),
            $this->getSchoolConfiguration($entity),
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

    private function getStateConfiguration($entity)
    {
        $state = $entity->getState();

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

    private function getCityConfiguration($entity)
    {
        $state = $entity->getState();
        $city = $entity->getCity();

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

    private function getSchoolConfiguration($entity)
    {
        $state = $entity->getState();
        $city = $entity->getCity();

        return [
            'type' => 'school',
            'name' => $entity->getName(),
            'url' => sprintf(
                '/escola/%s-%s/%s',
                $entity->getId(),
                $entity->getSlug(),
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
