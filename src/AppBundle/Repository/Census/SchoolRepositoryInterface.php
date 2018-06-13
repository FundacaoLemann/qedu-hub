<?php

namespace AppBundle\Repository\Census;

use AppBundle\Entity\School;
use AppBundle\Census\CensusEdition;

interface SchoolRepositoryInterface
{
    public function findSchoolCensusByEdition(School $school, CensusEdition $censusEdition);
}
