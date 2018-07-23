<?php

namespace AppBundle\Component;

use AppBundle\Util\Breadcrumb;
use AppBundle\Util\MenuBuilder;

class Header
{
    private $breadcrumb;
    private $breadcrumbItems = [];
    private $menu;
    private $menuItems = [];

    public function __construct(Breadcrumb $breadcrumb, MenuBuilder $menu)
    {
        $this->breadcrumb = $breadcrumb;
        $this->menu = $menu;
    }

    public function build($entity)
    {
        $this->breadcrumbItems = $this->breadcrumb->buildItems($entity);
        $this->menuItems = $this->menu->buildItems($entity);
    }

    public function getBreadcrumb() : array
    {
        return $this->breadcrumbItems;
    }

    public function getMenu() : array
    {
        return $this->menuItems;
    }
}
