<?php

namespace AppBundle\Util\Filter\Census;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class GarbageFilter extends AbstractExtension
{
    public function translate($censusServices)
    {
        if ($censusServices->hasPeriodicGarbageCollection()) {
            return 'Coleta periódica';
        } elseif ($censusServices->hasBurnGarbage()) {
            return 'Queima';
        } elseif ($censusServices->hasTransferGarbageToOtherArea()) {
            return 'Joga em outra área';
        } elseif ($censusServices->hasWasteRecycling()) {
            return 'Recicla';
        } elseif ($censusServices->hasGarbageBuried()) {
            return 'Enterra';
        } elseif ($censusServices->hasOtherGarbageDestination()) {
            return 'Outros';
        }

        return 'Não informado';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('garbageFilter', [$this, 'translate']),
        ];
    }
}
