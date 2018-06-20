<?php

namespace AppBundle\Repository\Census;

use AppBundle\Census\CensusEdition;
use AppBundle\Entity\School;

use Doctrine\ORM\EntityRepository;

class SchoolRepository extends EntityRepository implements SchoolRepositoryInterface
{
    public function findSchoolCensusByEdition(School $school, CensusEdition $censusEdition)
    {
        return $this->findOneBy([
            'schoolId' => $school->getId(),
            'educacenso' => $censusEdition->getYear(),
        ]);
    }
}
