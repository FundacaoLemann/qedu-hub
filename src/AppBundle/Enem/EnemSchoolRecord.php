<?php

namespace AppBundle\Enem;

use AppBundle\Entity\Enem\EnemSchoolParticipation;

class EnemSchoolRecord
{
    private $enemSchoolParticipation;

    public function __construct(?EnemSchoolParticipation $enemSchoolParticipation)
    {
        $this->enemSchoolParticipation = $enemSchoolParticipation;
    }

    public function getEnemSchoolParticipation()
    {
        return $this->enemSchoolParticipation;
    }
}
