<?php

namespace AppBundle\Learning;

use AppBundle\Entity\School;
use AppBundle\Repository\Learning\SchoolRepositoryInterface;

class SchoolProficiency implements ProficiencyInterface
{
    private $schoolRepository;
    private $provaBrasilService;

    public function __construct(SchoolRepositoryInterface $schoolRepository, ProvaBrasilService $provaBrasilService)
    {
        $this->schoolRepository = $schoolRepository;
        $this->provaBrasilService = $provaBrasilService;
    }

    public function hasProficiencyInLastEdition(School $school): bool
    {
        $provaBrasilEdition = $this->provaBrasilService->getLastEdition();

        $schools = $this->schoolRepository->findSchoolProficiencyByEdition($school, $provaBrasilEdition);

        if (is_null($schools)) {
            return false;
        }

        return true;
    }
}
