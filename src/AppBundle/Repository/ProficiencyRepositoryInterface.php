<?php

namespace AppBundle\Repository;

use AppBundle\Learning\ProvaBrasilEdition;

interface ProficiencyRepositoryInterface
{
    public function findBrazilProficiencyByEdition(ProvaBrasilEdition $provaBrasilEdition);
    public function findSchoolProficiencyByEdition(int $schoolId, ProvaBrasilEdition $provaBrasilEdition);
}
