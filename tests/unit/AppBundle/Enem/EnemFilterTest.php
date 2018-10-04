<?php

namespace Tests\Unit\AppBundle\Census;

use AppBundle\Enem\EnemEdition;
use AppBundle\Enem\EnemFilter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EnemFilterTest extends TestCase
{
    public function testIsBlockedShouldReturnFalseWhenUserIsLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsLogged();

        $filter = new EnemFilter($authorizationChecker);

        $this->assertFalse($filter->isBlocked());
    }

    public function testIsBlockedShouldReturnTrueWhenUserIsNotLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsNotLogged();

        $filter = new EnemFilter($authorizationChecker);

        $this->assertTrue($filter->isBlocked());
    }

    public function testGetYearsShouldReturnYearsAvailable()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();

        $filter = new EnemFilter($authorizationChecker);

        $expectedYears = [
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

        $this->assertEquals($expectedYears, $filter->getYears());
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
}
