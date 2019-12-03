<?php

namespace AppBundle\Enem;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EnemFilter
{
    private $authorizationChecker;
    private $enemEditionSelected;
    private $years = [
        2018,
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

    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        EnemEditionSelected $enemEditionSelected
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->enemEditionSelected = $enemEditionSelected;
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
        return $this->enemEditionSelected->getEnemEdition()->getYear();
    }
}
