<?php

namespace Tests\Unit\AppBundle\Component;

use AppBundle\Component\Header;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testBuildShouldConstructBreadcrumb()
    {
        $breadcrumb = $this->getBreadcrumbMock();
        $menu = $this->createMock('AppBundle\Util\MenuBuilder');
        $school = $this->getSchoolMock();

        $header = new Header($breadcrumb, $menu);
        $header->build($school);

        $this->assertTrue(is_array($header->getBreadCrumb()));
    }

    public function testBuildShouldConstructMenu()
    {
        $breadcrumb = $this->createMock('AppBundle\Component\Breadcrumb');
        $menu = $this->getMenuMock();
        $school = $this->getSchoolMock();

        $header = new Header($breadcrumb, $menu);
        $header->build($school);

        $this->assertTrue(is_array($header->getMenu()));
    }

    private function getBreadcrumbMock()
    {
        $breadcrumb = $this->createMock('AppBundle\Component\Breadcrumb');
        $breadcrumb->expects($this->once())
            ->method('buildItems')
            ->with($this->getSchoolMock())
            ->willReturn($breadcrumbItems = []);

        return $breadcrumb;
    }

    private function getMenuMock()
    {
        $menu = $this->createMock('AppBundle\Util\MenuBuilder');
        $menu->expects($this->once())
            ->method('buildItems')
            ->with($this->getSchoolMock())
            ->willReturn($menuItems = []);

        return $menu;
    }

    private function getSchoolMock()
    {
        return $this->createMock('AppBundle\Entity\School');
    }
}
