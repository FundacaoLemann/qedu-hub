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
        $this->brazilLearning = new BrazilLearning();
    }

    public function create(array $proficiencies)
    {
        foreach ($proficiencies as $proficiency) {
            $learning = $this->createLearning($proficiency);

            $dimPoliticAggregation = $proficiency->getDimPoliticAggregation();

            $this->brazilLearning->add(
                $learning,
                $dimPoliticAggregation->getGradeId(),
                $dimPoliticAggregation->getDisciplineId()
            );
        }

        return $this->brazilLearning;
    }

    private function createLearning(Proficiency $proficiency): Learning
    {
        $percentage = $this->learningCalculator->calculate($proficiency);
        $totalSuccessfulStudents = (int) $proficiency->getLevelOptimal();
        $totalStudents = (int) $proficiency->getWithProficiencyWeight();

        $learning = new Learning($percentage, $totalSuccessfulStudents, $totalStudents);

        return $learning;
    }
}
