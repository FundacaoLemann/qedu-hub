<?php

namespace AppBundle\Census;

use AppBundle\Entity\Census\School;
use AppBundle\Repository\Census\SchoolRepositoryInterface;

class CensusService implements CensusServiceInterface
{
    private $schoolRepository;
    private $censusEditionSelected;

    public function __construct(
        SchoolRepositoryInterface $schoolRepository,
        CensusEditionSelected $censusEditionSelected
    ) {
        $this->schoolRepository = $schoolRepository;
        $this->censusEditionSelected = $censusEditionSelected;
    }

    public function getCensusByEdition($school) : ?School
    {
        $censusEdition = $this->censusEditionSelected->getCensusEdition();

        return $this->schoolRepository->findSchoolCensusByEdition($school, $censusEdition);
    }
}
