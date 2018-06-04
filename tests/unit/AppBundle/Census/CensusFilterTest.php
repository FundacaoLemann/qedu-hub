<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Census\CensusFilter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CensusFilterTest extends TestCase
{
    public function testIsBlockedShouldReturnFalseWhenUserIsLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsLogged();
        $request = $this->createRequestStackMock();

        $filter = new CensusFilter($authorizationChecker, $request);

        $this->assertFalse($filter->isBlocked());
    }

    public function testIsBlockedShouldReturnTrueWhenUserIsNotLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsNotLogged();
        $request = $this->createRequestStackMock();

        $filter = new CensusFilter($authorizationChecker, $request);

        $this->assertTrue($filter->isBlocked());
    }

    public function testGetYearsShouldReturnYearsAvailable()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $request = $this->createRequestStackMock();

        $filter = new CensusFilter($authorizationChecker, $request);

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

    public function testGetCurrentYearShouldReturnDefaultYear()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $request = $this->createRequestStackWithoutQueryString();

        $filter = new CensusFilter($authorizationChecker, $request);

        $defaultYearExpected = 2017;

        $this->assertEquals($defaultYearExpected, $filter->getCurrentYear());
    }

    public function testGetCurrentYearShouldReturnYearBasedOnRequest()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $request = $this->createRequestStackWithYearSettledInQueryString();

        $filter = new CensusFilter($authorizationChecker, $request);

        $yearExpected = 2011;

        $this->assertEquals($yearExpected, $filter->getCurrentYear());
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

    private function createRequestStackWithoutQueryString()
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $requestMock->method('get')
            ->with('year', $defaultYear = 2017)
            ->willReturn($defaultYear);

        $requestStackMock = $this->createRequestStackMock();
        $requestStackMock->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }

    private function createRequestStackWithYearSettledInQueryString()
    {
        $requestMock = $this->createMock('Symfony\Component\HttpFoundation\Request');
        $requestMock->method('get')
            ->with('year', $defaultYear = 2017)
            ->willReturn($selectedYear = 2011);

        $requestStackMock = $this->createRequestStackMock();
        $requestStackMock->method('getCurrentRequest')
            ->willReturn($requestMock);

        return $requestStackMock;
    }

    public function createRequestStackMock()
    {
        return $this->createMock('Symfony\Component\HttpFoundation\RequestStack');
    }
}
