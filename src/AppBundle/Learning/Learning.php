<?php

namespace AppBundle\Learning;

use AppBundle\Entity\Proficiency;

class Learning
{
    private $proficiency;
    private $percentage;

    public function __construct(Proficiency $proficiency, $percentage)
    {
        $this->proficiency = $proficiency;
        $this->percentage = $percentage;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }

    public function getTotalSuccessfulStudents(): int
    {
        return round($this->proficiency->getLevelOptimal(), 0);
    }

    public function getTotalStudents(): int
    {
        return ceil($this->proficiency->getWithProficiencyWeight());
    }

    public function getGradeId(): int
    {
        return $this->proficiency->getDimPoliticAggregation()->getGradeId();
    }

    public function getDisciplineId(): int
    {
        return $this->proficiency->getDimPoliticAggregation()->getDisciplineId();
    }
}
