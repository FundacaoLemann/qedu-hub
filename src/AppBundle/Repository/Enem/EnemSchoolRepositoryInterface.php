<?php

namespace AppBundle\Repository\Enem;

use AppBundle\Entity\School;
use AppBundle\Enem\EnemEdition;

interface EnemSchoolRepositoryInterface
{
    public function findEnemSchoolParticipationByEdition(School $school, EnemEdition $enemEdition);
}
