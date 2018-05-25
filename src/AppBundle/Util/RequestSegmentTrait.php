<?php

namespace AppBundle\Util;

trait RequestSegmentTrait
{
    private function getLastUrlSegment(string $pathInfo)
    {
        $urlSegments = explode('/', $pathInfo);
        $lastUrlSegment = end($urlSegments);

        return $lastUrlSegment;
    }
}
