<?php

namespace AppBundle\Learning;

use AppBundle\Entity\Proficiency;

interface LearningCalculatorInterface
{
    public function calculate(Proficiency $proficiency): int;
}
