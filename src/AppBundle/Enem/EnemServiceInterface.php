<?php

namespace AppBundle\Enem;

use AppBundle\Entity\School;

interface EnemServiceInterface
{
    public function getEnemByEdition(School $entity);
}
