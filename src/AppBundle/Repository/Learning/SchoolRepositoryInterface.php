<?php

namespace AppBundle\Repository\Learning;

use AppBundle\Entity\School;
use AppBundle\Learning\ProvaBrasilEdition;

interface SchoolRepositoryInterface
{
    public function findSchoolProficiencyByEdition(School $school, ProvaBrasilEdition $provaBrasilEdition);
}
