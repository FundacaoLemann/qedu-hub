<?php

namespace AppBundle\Repository\Enem;

use AppBundle\Enem\EnemEdition;
use AppBundle\Entity\EducationEntity;
use AppBundle\Entity\School;

use Doctrine\ORM\EntityRepository;

class EnemSchoolParticipationRepository extends EntityRepository implements EnemSchoolParticipationRepositoryInterface
{
    public function findEnemSchoolParticipationByEdition(School $school, EnemEdition $enemEdition)
    {
        $queryBuilder = $this->createQueryBuilder('esp');

        return $queryBuilder->join(EducationEntity::class, 'ee', 'WITH', "esp.schoolId = ee.id AND ee.type = 'school'")
            ->andWhere('esp.edition = ' . $enemEdition->getYear())
            ->andWhere('ee.oldId = ' . $school->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
