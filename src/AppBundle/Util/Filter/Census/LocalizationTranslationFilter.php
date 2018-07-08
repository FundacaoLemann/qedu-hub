<?php

namespace AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;

class LocalizationTranslationFilter extends AbstractExtension
{
	public function localizationTranslationFilter(School $school)
    {
        $localizationId = $school->getLocalizationId();

        switch ($localizationId) {
            case 1:
                return 'Urbana';
            case 2:
                return 'Rural';
            default:
                return '-';
        }
	}
}
