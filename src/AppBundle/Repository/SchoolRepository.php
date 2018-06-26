<?php

namespace AppBundle\Repository;

use AppBundle\Entity\School;
use Doctrine\ORM\EntityRepository;

class SchoolRepository extends EntityRepository implements SchoolRepositoryInterface
{
    public function findSchoolById(int $schoolId): ?School
    {
        return $this->findOneBy([
            'id' => $schoolId,
        ]);
    }
}
