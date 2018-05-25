<?php

namespace AppBundle\Learning;

use AppBundle\Entity\School;

interface ProficiencyInterface
{
    public function hasProficiencyInLastEdition(School $school): bool;
}
