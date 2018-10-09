<?php

namespace Tests\Unit\AppBundle\Enem;

use AppBundle\Enem\EnemEdition;
use AppBundle\Enem\EnemFilter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EnemFilterTest extends TestCase
{
    public function testIsBlockedShouldReturnFalseWhenUserIsLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsLogged();
        $enemEditionSelected = $this->createEnemEditionSelectedMock();

        $filter = new EnemFilter($authorizationChecker, $enemEditionSelected);

        $this->assertFalse($filter->isBlocked());
    }

    public function testIsBlockedShouldReturnTrueWhenUserIsNotLogged()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMockWhenUserIsNotLogged();
        $enemEditionSelected = $this->createEnemEditionSelectedMock();

        $filter = new EnemFilter($authorizationChecker, $enemEditionSelected);

        $this->assertTrue($filter->isBlocked());
    }

    public function testGetYearsShouldReturnYearsAvailable()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $enemEditionSelected = $this->createEnemEditionSelectedMock();

        $filter = new EnemFilter($authorizationChecker, $enemEditionSelected);

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

    public function testGetCurrentYearShouldReturnEnemEdition()
    {
        $authorizationChecker = $this->createAuthorizationCheckerMock();
        $enemEditionSelected = $this->createEnemEditionSelectedMock();
        $enemEditionSelected->expects($this->once())
            ->method('getEnemEdition')
            ->willReturn(new EnemEdition(2017));

        $filter = new EnemFilter($authorizationChecker, $enemEditionSelected);

        $enemEditionExpected = 2017;

        $this->assertEquals($enemEditionExpected, $filter->getCurrentYear());
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

    private function createEnemEditionSelectedMock()
    {
        return $this->createMock('AppBundle\Enem\EnemEditionSelected');
    }
}
