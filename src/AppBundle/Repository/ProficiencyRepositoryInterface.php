<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Learning\School;
use AppBundle\Learning\ProvaBrasilEdition;

interface ProficiencyRepositoryInterface
{
    public function findBrazilProficiencyByEdition(ProvaBrasilEdition $provaBrasilEdition);
    public function findSchoolProficiencyByEdition(School $school, ProvaBrasilEdition $provaBrasilEdition);
}
