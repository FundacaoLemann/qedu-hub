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

    public function getBrazilLearningByEdition(ProvaBrasilEdition $provaBrasilEdition): BrazilLearning
    {
        $brazilProficiency = $this->proficiencyRepository->findBrazilProficiencyByEdition($provaBrasilEdition);

        return $this->learningFactory->create($brazilProficiency);
    }
}
