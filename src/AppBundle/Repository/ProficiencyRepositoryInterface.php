<?php

namespace AppBundle\Repository;

use AppBundle\Learning\ProvaBrasilEdition;

interface ProficiencyRepositoryInterface
{
    public function findBrazilProficiencyByEdition(ProvaBrasilEdition $provaBrasilEdition);
}
