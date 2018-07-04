<?php

namespace AppBundle\Census;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CensusFilter
{
    private $authorizationChecker;
    private $censusEditionSelected;
    private $years = [
        2017,
        2016,
        2015,
        2014,
        2013,
        2012,
        2011,
        2010,
    ];

    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        CensusEditionSelected $censusEditionSelected
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->censusEditionSelected = $censusEditionSelected;
    }

    public function isBlocked()
    {
        return $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY') === false;
    }

    public function getYears()
    {
        return $this->years;
    }

    public function getCurrentYear()
    {
        return $this->censusEditionSelected->getCensusEdition()->getYear();
    }
}
