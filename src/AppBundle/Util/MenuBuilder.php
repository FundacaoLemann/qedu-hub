<?php

namespace AppBundle\Util;

use AppBundle\Entity\School;
use AppBundle\Learning\ProficiencyInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    use RequestSegmentTrait;

    private $proficiency;
    private $items = [
        'learning' => [
            'name' => 'Aprendizado',
            'url' => '/escola/%s-%s/aprendizado',
            'icon' => 'icon-page-learning',
            'isActive' => false,
        ],
        'compare' => [
            'name' => 'Compare',
            'url' => '/escola/%s-%s/compare',
            'icon' => 'icon-page-compare',
            'isActive' => false,
        ],
        'evolution' => [
            'name' => 'Evolução',
            'url' => '/escola/%s-%s/evolucao',
            'icon' => 'icon-page-evolution',
            'isActive' => false,
        ],
        'proficiency' => [
            'name' => 'Proficiência',
            'url' => '/escola/%s-%s/proficiencia',
            'icon' => 'icon-page-proficiency',
            'isActive' => false,
        ],
        'explore' => [
            'name' => 'Explore',
            'url' => '/escola/%s-%s/explorar',
            'icon' => 'icon-page-explore',
            'isActive' => false,
        ],
        'people' => [
            'name' => 'Pessoas',
            'url' => '/escola/%s-%s/pessoas',
            'icon' => 'icon-page-director',
            'isActive' => false,
        ],
        'census' => [
            'name' => 'Censo',
            'url' => '/escola/%s-%s/censo-escolar',
            'icon' => 'icon-page-census',
            'isActive' => false,
        ],
        'ideb' => [
            'name' => 'Ideb',
            'url' => '/escola/%s-%s/ideb',
            'icon' => 'icon-page-ideb',
            'isActive' => false,
        ],
        'about' => [
            'name' => 'Sobre a Escola',
            'url' => '/escola/%s-%s/sobre',
            'icon' => 'icon-page-about',
            'isActive' => false,
        ],
        'enem' => [
            'name' => 'Enem',
            'url' => '/escola/%s-%s/enem',
            'icon' => 'icon-page-enem',
            'isActive' => false,
        ],
    ];

    public function __construct(ProficiencyInterface $proficiency)
    {
        $this->proficiency = $proficiency;
    }

    public function buildItems(School $school, Request $request)
    {
        $this->setActiveItem($request);

        if ($this->proficiency->hasProficiencyInLastEdition($school) === false) {
            $items[] = $this->items['about'];
            $items[] = $this->items['enem'];

            $items = $this->mountUrl($items, $school);

            return $items;
        }

        $items[] = $this->items['learning'];
        $items[] = $this->items['compare'];
        $items[] = $this->items['evolution'];
        $items[] = $this->items['proficiency'];
        $items[] = $this->items['explore'];
        $items[] = $this->items['people'];
        $items[] = $this->items['census'];
        $items[] = $this->items['ideb'];
        $items[] = $this->items['enem'];

        $items = $this->mountUrl($items, $school);

        return $items;
    }

    private function mountUrl(array $items, School $school)
    {
        foreach ($items as &$item) {
            $item['url'] = sprintf(
                $item['url'],
                $school->getId(),
                $school->getSlug()
            );
        }

        return $items;
    }

    private function setActiveItem(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $lastSegmentFromRequest = $this->getLastUrlSegment($pathInfo);

        foreach ($this->items as $key => $item) {
            $lastSegmentFromMenuItem = $this->getLastUrlSegment($item['url']);

            if ($lastSegmentFromRequest === $lastSegmentFromMenuItem) {
                $this->items[$key]['isActive'] = true;
            }
        }
    }
}
