<?php

namespace AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DependenceTranslationFilter extends AbstractExtension
{
    public function dependenceTranslationFilter(School $school)
    {
        $dependenceId = $school->getDependenceId();

        switch ($dependenceId) {
            case 0:
                return 'Todas';
            case 1:
                return 'Federal';
            case 2:
                return 'Estadual';
            case 3:
                return 'Municipal';
            case 4:
                return 'Privada';
            default:
                return '-';
        }
    }

    public function getFilters()
    {
        return [
            new TwigFilter('dependenceTranslationFilter', [$this, 'dependenceTranslationFilter']),
        ];
    }
}
