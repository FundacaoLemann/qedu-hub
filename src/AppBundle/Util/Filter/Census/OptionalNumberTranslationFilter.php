<?php

namespace AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OptionalNumberTranslationFilter extends AbstractExtension
{
	public function optionalNumberTranslationFilter($number)
    {
        if (is_null($number)) {
            return '-';
        }

        return $number;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('optionalNumberTranslationFilter', [$this, 'optionalNumberTranslationFilter']),
        ];
    }
}
