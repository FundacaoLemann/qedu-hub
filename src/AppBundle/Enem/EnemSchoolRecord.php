<?php

namespace AppBundle\Enem;

use AppBundle\Entity\Enem\EnemSchoolParticipation;
use AppBundle\Entity\Enem\EnemSchoolResults;

class EnemSchoolRecord
{
    private $enemSchoolParticipation;
    private $enemSchoolResults;

    public function __construct(
        ?EnemSchoolParticipation $enemSchoolParticipation,
        ?EnemSchoolResults $enemSchoolResults
    ) {
        $this->enemSchoolParticipation = $enemSchoolParticipation;
        $this->enemSchoolResults = $enemSchoolResults;
    }

    public function getEnemSchoolParticipation()
    {
        return $this->enemSchoolParticipation;
    }

    public function getEnemSchoolResults()
    {
        return $this->enemSchoolResults;
    }

    public function isRepresentative() : bool
    {
        $participationRate = $this->enemSchoolParticipation->getParticipationRate();
        $participationCount = $this->enemSchoolParticipation->getParticipationCount();

        if ($participationRate < 0.5 || $participationCount < 10) {
            return false;
        }

        return true;
    }
}
