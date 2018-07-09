<?php

namespace AppBundle\Util\Filter\Census;

use AppBundle\Entity\School;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneFilter extends AbstractExtension
{
    public function phoneFilter(School $school)
    {
        $phone = $school->getPhone();
        $ddd = $school->getDdd();

        if (!$phone || !$ddd) {
            return 'Não informado';
        }

        $phoneFormatted = '(' . $ddd . ') ' . substr($phone, 0, 4) . '-' . substr($phone, 4, 4);

        return $phoneFormatted;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('phoneFilter', [$this, 'phoneFilter']),
        ];
    }
}
