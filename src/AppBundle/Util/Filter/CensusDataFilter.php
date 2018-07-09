<?php

namespace AppBundle\Util\Filter;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CensusDataFilter extends AbstractExtension
{
    

    

    public function waterSupplierFilter($censusServices)
    {
        if ($censusServices->hasWaterPublicNetwork()) {
            return 'Rede pública';
        } elseif ($censusServices->hasArtesianWellWater()) {
            return 'Poço artesiano';
        } elseif ($censusServices->hasWaterReservoir()) {
            return 'Cacimba';
        } elseif ($censusServices->hasWaterRiver()) {
            return 'Rio';
        } elseif ($censusServices->hasNotWater()) {
            return 'Inexistente';
        }

        return 'Não informado';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('waterSupplierFilter', [$this, 'waterSupplierFilter']),
        ];
    }
}
