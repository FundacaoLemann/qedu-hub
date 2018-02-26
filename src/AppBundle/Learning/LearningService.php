<?php

namespace AppBundle\Learning;

use AppBundle\Repository\ProficiencyRepositoryInterface;

class LearningService
{
    private $proficiencyRepository;
    private $learningFactory;

    public function __construct(
        ProficiencyRepositoryInterface $proficiencyRepository,
        LearningFactoryInterface $learningFactory
    ) {
        $this->proficiencyRepository = $proficiencyRepository;
        $this->learningFactory = $learningFactory;
    }

    public function getBrazilLearningByEdition(ProvaBrasilEdition $provaBrasilEdition): array
    {
        $brazilProficiency = $this->proficiencyRepository->findBrazilProficiencyByEdition($provaBrasilEdition);

        return $this->learningFactory->create($brazilProficiency);
    }

    public function getSchoolLearningByEdition(int $schoolId, ProvaBrasilEdition $provaBrasilEdition): array
    {
        $schoolProficiency = $this->proficiencyRepository->findSchoolProficiencyByEdition(
            $schoolId,
            $provaBrasilEdition
        );

        return $this->learningFactory->create($schoolProficiency);
    }
}
