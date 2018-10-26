<?php

namespace AppBundle\Repository\Enem;

use AppBundle\Entity\Enem\EnemSchoolParticipation;
use Doctrine\ORM\EntityRepository;

class EnemSchoolResultsRepository extends EntityRepository implements EnemSchoolResultsRepositoryInterface
{
    public function findEnemSchoolResultsByEnemSchoolParticipation(EnemSchoolParticipation $enemSchoolParticipation)
    {
        $queryBuilder = $this->createQueryBuilder('esr');

        return $queryBuilder->andWhere('esr.schoolParticipationId = ' . $enemSchoolParticipation->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
