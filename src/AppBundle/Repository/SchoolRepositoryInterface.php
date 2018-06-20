<?php

namespace AppBundle\Repository;

use AppBundle\Entity\School;

interface SchoolRepositoryInterface
{
    public function findSchoolById(int $schoolId): ?School;
}
