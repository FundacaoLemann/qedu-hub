<?php

namespace AppBundle\Repository\Learning;

use AppBundle\Entity\School;
use AppBundle\Learning\ProvaBrasilEdition;
use Doctrine\ORM\EntityRepository;

class SchoolRepository extends EntityRepository implements SchoolRepositoryInterface
{
    public function findSchoolProficiencyByEdition(School $school, ProvaBrasilEdition $provaBrasilEdition)
    {
        return $this->findBy([
            'id' => $school->getId(),
            'editionId' => $provaBrasilEdition->getCode(),
        ]);
    }
}
