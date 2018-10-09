<?php

namespace AppBundle\Enem;

use Symfony\Component\HttpFoundation\RequestStack;

class EnemEditionSelected
{
    private $request;
    private $defaultYear = 2017;
    private $years = [
        2017,
        2016,
        2015,
        2014,
        2013,
        2012,
        2011,
        2010,
        2009
    ];

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getEnemEdition() : EnemEdition
    {
        $year = (int) $this->request->get('year', $this->defaultYear);

        if (in_array($year, $this->years) === false) {
            return new EnemEdition($this->defaultYear);
        }

        return new EnemEdition($year);
    }
}
