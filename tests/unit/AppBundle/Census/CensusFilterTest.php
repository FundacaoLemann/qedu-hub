<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusEdition;
use AppBundle\Census\CensusFilter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CensusFilterTest extends TestCase
{
    public function testIsBlockedShouldReturnFalseWhenUserIsLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsLogged();
        $censusEditionSelected = $this->createCensusEditionSelectedMock();

        $filter = new CensusFilter($authorizationChecker, $censusEditionSelected);

        $this->assertFalse($filter->isBlocked());
    }

    public function testIsBlockedShouldReturnTrueWhenUserIsNotLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsNotLogged();
        $censusEditionSelected = $this->createCensusEditionSelectedMock();

        $filter = new CensusFilter($authorizationChecker, $censusEditionSelected);

        $this->assertTrue($filter->isBlocked());
    }

    public function testGetYearsShouldReturnYearsAvailable()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $censusEditionSelected = $this->createCensusEditionSelectedMock();

        $filter = new CensusFilter($authorizationChecker, $censusEditionSelected);

        $expectedYears = [
            2017,
            2016,
            2015,
            2014,
            2013,
            2012,
            2011,
            2010,
        ];

        $this->assertEquals($expectedYears, $filter->getYears());
    }

    public function testGetCurrentYearShouldReturnCensusEdition()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $censusEditionSelected = $this->createCensusEditionSelectedMock();
        $censusEditionSelected->expects($this->once())
            ->method('getCensusEdition')
            ->willReturn(new CensusEdition(2017));

        $filter = new CensusFilter($authorizationChecker, $censusEditionSelected);

        $censusEditionExpected = 2017;

        $this->assertEquals($censusEditionExpected, $filter->getCurrentYear());
    }

    private function createAuthorizationCheckerMockWhenUserIsLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();

        $authorizationChecker->method('isGranted')
            ->with('IS_AUTHENTICATED_FULLY')
            ->willReturn(true);

        return $authorizationChecker;
    }

    private function createAuthorizationCheckerMockWhenUserIsNotLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();

        $authorizationChecker->method('isGranted')
            ->with('IS_AUTHENTICATED_FULLY')
            ->willReturn(false);

        return $authorizationChecker;
    }

    private function createAuthorizationCheckerMock()
    {
        return $this->createMock(AuthorizationCheckerInterface::class);
    }

    private function createCensusEditionSelectedMock()
    {
        return $this->createMock('AppBundle\Census\CensusEditionSelected');
    }
}
