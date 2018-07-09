<?php

namespace AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ConvertBooleanToYesNoFilter extends AbstractExtension
{
	public function convertBooleanToYesNoFilter($answer)
    {
        if ($answer === true) {
            return "<span style='color: darkgreen'>Sim</span>";
        } elseif ($answer === false) {
            return "<span style='color: red'>Não</span>";
        }

        return "<span style='color: #666'>Não informado</span>";
    }

    public function getFilters()
    {
        return [
            new TwigFilter('convertBooleanToYesNoFilter', [$this, 'convertBooleanToYesNoFilter']),
        ];
    }
}
