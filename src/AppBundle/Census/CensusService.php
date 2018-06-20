<?php

namespace AppBundle\Census;

use AppBundle\Entity\Census\School;
use AppBundle\Repository\Census\SchoolRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CensusService implements CensusServiceInterface
{
    private $schoolRepository;
    private $request;

    public function __construct(
        SchoolRepositoryInterface $schoolRepository,
        RequestStack $requestStack
    ) {
        $this->schoolRepository = $schoolRepository;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getCensusByEdition($school) : ?School
    {
        $year = (int) $this->request->get('year');
        $censusEdition = new CensusEdition($year);

        return $this->schoolRepository->findSchoolCensusByEdition($school, $censusEdition);
    }
}
