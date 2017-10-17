<?php

namespace AppBundle\Learning;

use AppBundle\Entity\Proficiency;

class LearningFactory implements LearningFactoryInterface
{
    private $learningCalculator;
    private $brazilLearning;

    public function __construct(LearningCalculatorInterface $learningCalculator)
    {
        $this->learningCalculator = $learningCalculator;
        $this->brazilLearning = [];
    }

    public function create(array $proficiencies): array
    {
        foreach ($proficiencies as $proficiency) {
            $this->brazilLearning[] = $this->createLearning($proficiency);
        }

        return $this->brazilLearning;
    }

    private function createLearning(Proficiency $proficiency): Learning
    {
        $percentage = $this->learningCalculator->calculate($proficiency);

        $learning = new Learning($proficiency, $percentage);

        return $learning;
    }
}
