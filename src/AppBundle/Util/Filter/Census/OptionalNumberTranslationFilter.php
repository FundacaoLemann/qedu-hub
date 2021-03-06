<?php

namespace AppBundle\Util\Filter\Census;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OptionalNumberTranslationFilter extends AbstractExtension
{
    public function translate($number)
    {
        if (is_null($number)) {
            return '-';
        }

        return $number;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('optionalNumberTranslationFilter', [$this, 'translate']),
        ];
    }
}
