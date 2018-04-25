<?php

namespace AppBundle\Repository;

use AppBundle\Entity\School;
use AppBundle\Learning\ProvaBrasilEdition;

interface ProficiencyRepositoryInterface
{
    public function findBrazilProficiencyByEdition(ProvaBrasilEdition $provaBrasilEdition);
    public function findSchoolProficiencyByEdition(School $school, ProvaBrasilEdition $provaBrasilEdition);
}
