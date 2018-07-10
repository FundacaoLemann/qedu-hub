<?php

namespace AppBundle\Util\Filter\Census;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PowerSupplierFilter extends AbstractExtension
{
    public function translate($censusServices)
    {
        if ($censusServices->hasPublicNetworkPower()) {
            return 'Rede pública';
        } elseif ($censusServices->hasGeneratorPower()) {
            return 'Gerador';
        } elseif ($censusServices->hasPowerFromOthersSources()) {
            return 'Outros';
        } elseif ($censusServices->hasNotEnergy()) {
            return 'Inexistente';
        }

        return 'Não informado';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('powerSupplierFilter', [$this, 'translate']),
        ];
    }
}
