<?php

namespace AppBundle\Census;

use Symfony\Component\HttpFoundation\RequestStack;

class CensusEditionSelected
{
    private $request;
    private $defaultYear = 2020;
    private $years = [
        2020,
        2018,
        2017,
        2016,
        2015,
        2014,
        2013,
        2012,
        2011,
        2010,
    ];

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getCensusEdition() : CensusEdition
    {
        $year = (int) $this->request->get('year', $this->defaultYear);

        if (in_array($year, $this->years) === false) {
            return new CensusEdition($this->defaultYear);
        }

        return new CensusEdition($year);
    }
}
