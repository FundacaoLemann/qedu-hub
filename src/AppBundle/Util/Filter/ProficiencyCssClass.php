<?php

namespace AppBundle\Util\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ProficiencyCssClass extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('proficiencyCssClass', [$this, 'proficiencyCssClassFilter']),
        ];
    }

    public function proficiencyCssClassFilter($percentage)
    {
        if ($percentage == 0) {
            return $this->getCssClass('0');
        }

        if ($percentage == 100) {
            return $this->getCssClass('10');
        }

        if ($percentage < 10) {
            return $this->getCssClass('1');
        }

        return $this->getCssClass(mb_substr($percentage, 0, 1));
    }

    private function getCssClass($percentage)
    {
        return sprintf('optimal-decile-bg-%s', $percentage);
    }
}
