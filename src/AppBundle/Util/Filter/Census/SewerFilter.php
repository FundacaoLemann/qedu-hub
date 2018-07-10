<?php

namespace AppBundle\Util\Filter\Census;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SewerFilter extends AbstractExtension
{
    public function translate($censusServices)
    {
        if ($censusServices->hasPublicSewerSystem()) {
            return 'Rede pública';
        } elseif ($censusServices->hasSepticTank()) {
            return 'Fossa';
        } elseif ($censusServices->hasNotSewerSystem()) {
            return 'Inexistente';
        }

        return 'Não informado';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('sewerFilter', [$this, 'translate']),
        ];
    }
}
