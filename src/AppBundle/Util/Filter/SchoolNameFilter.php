<?php

namespace AppBundle\Util\Filter;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SchoolNameFilter extends AbstractExtension
{
    public function translate(School $school)
    {
        $prefix = $school->getNamePrefix();
        $name = $school->getNameStandard();

        $name = mb_convert_case($name, MB_CASE_TITLE);

        if (! $prefix) {
            return $name;
        }

        if (in_array($prefix, ['EM', 'EMEF', 'EE'])) {
            return $prefix . ' ' . $name;
        }

        $prefix = mb_convert_case($prefix, MB_CASE_TITLE);

        return $prefix . ' ' . $name;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('schoolNameFilter', [$this, 'translate']),
        ];
    }
}
