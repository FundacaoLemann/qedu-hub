<?php

namespace AppBundle\Repository\Enem;

use AppBundle\Entity\School;
use AppBundle\Enem\EnemEdition;

interface EnemSchoolParticipationRepositoryInterface
{
    public function findEnemSchoolParticipationByEdition(School $school, EnemEdition $enemEdition);
}
