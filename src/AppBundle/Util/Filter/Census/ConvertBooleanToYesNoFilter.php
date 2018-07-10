<?php

namespace AppBundle\Util\Filter\Census;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ConvertBooleanToYesNoFilter extends AbstractExtension
{
    public function translate($answer)
    {
        if ($answer === true) {
            return "<span style='color: darkgreen'>Sim</span>";
        } elseif ($answer === false) {
            return "<span style='color: red'>Não</span>";
        }

        return "<span style='color: #666'>-</span>";
    }

    public function getFilters()
    {
        return [
            new TwigFilter('convertBooleanToYesNoFilter', [$this, 'translate']),
        ];
    }
}
