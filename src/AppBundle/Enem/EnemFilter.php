<?php

namespace AppBundle\Enem;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EnemFilter
{
    private $authorizationChecker;
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

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
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
        return 2017;
    }
}
