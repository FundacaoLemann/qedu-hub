<?php

namespace AppBundle\Util\Filter;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CensusDataFilter extends AbstractExtension
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
            new TwigFilter('convertNumberToYesNoFilter', [$this, 'convertNumberToYesNoFilter']),
            new TwigFilter('waterSupplierFilter', [$this, 'waterSupplierFilter']),
        ];
    }
}
