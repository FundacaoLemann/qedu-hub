<?php

namespace AppBundle\Census;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CensusFilter
{
    private $authorizationChecker;
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
    ];

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, RequestStack $request)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->request = $request;
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
        return $this->request->getCurrentRequest()->get('year', $this->defaultYear);
    }
}
