<?php

namespace AppBundle\Repository\Enem;

use AppBundle\Entity\Enem\EnemSchoolParticipation;

interface EnemSchoolResultsRepositoryInterface
{
    public function findEnemSchoolResultsByEnemSchoolParticipation(EnemSchoolParticipation $enemSchoolParticipation);
}
