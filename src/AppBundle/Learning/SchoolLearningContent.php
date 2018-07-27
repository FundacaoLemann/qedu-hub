<?php

namespace AppBundle\Learning;

use AppBundle\Entity\School;
use AppBundle\Exception\SchoolLearningNotFoundException;
use AppBundle\Exception\SchoolNotFoundException;
use AppBundle\Repository\SchoolRepositoryInterface;
use AppBundle\Repository\Learning\SchoolRepositoryInterface as SchoolLearningRepositoryInterface;

class SchoolLearningContent
{
    private $schoolRepository;
    private $school;
    private $schoolLearningRepository;
    private $schoolLearning = [];
    private $learningService;

    public function __construct(
        SchoolRepositoryInterface $schoolRepository,
        SchoolLearningRepositoryInterface $schoolLearningRepository,
        LearningService $learningService
    ) {
        $this->schoolRepository = $schoolRepository;
        $this->schoolLearningRepository = $schoolLearningRepository;
        $this->learningService = $learningService;
    }

    public function build(int $schoolId, ProvaBrasilEdition $provaBrasilEdition)
    {
        $this->school = $this->schoolRepository->findSchoolById($schoolId);

        if (is_null($this->school)) {
            throw new SchoolNotFoundException();
        }

        $schoolProficiency = $this->schoolLearningRepository->findSchoolProficiencyByEdition(
            $this->school,
            $provaBrasilEdition
        );

        if (is_null($schoolProficiency)) {
            throw new SchoolLearningNotFoundException();
        }

        $this->schoolLearning = $this->learningService->getSchoolLearningByEdition(
            $schoolProficiency,
            $provaBrasilEdition
        );
    }

    public function getSchool() : ?School
    {
        return $this->school;
    }

    public function getSchoolLearning() : array
    {
        return $this->schoolLearning;
    }
}
