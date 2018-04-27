<?php

namespace AppBundle\Repository;

use AppBundle\Entity\DimPoliticAggregation;
use AppBundle\Entity\DimRegionalAggregation;
use AppBundle\Entity\School;
use AppBundle\Learning\ProvaBrasilEdition;
use Doctrine\ORM\EntityRepository;

class ProficiencyRepository extends EntityRepository implements ProficiencyRepositoryInterface
{
    public function findBrazilProficiencyByEdition(ProvaBrasilEdition $provaBrasilEdition)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder
            ->join(DimRegionalAggregation::class, 'dra', 'WITH', 'p.dimRegionalAggregationId = dra.id')
            ->andWhere('dra.stateId = 100')
            ->andWhere('dra.schoolId = 0')
            ->andWhere('dra.cityId = 0')

            ->join(DimPoliticAggregation::class, 'dpa', 'WITH', 'p.dimPoliticAggregationId = dpa.id')
            ->andWhere('dpa.localizationId = 0')
            ->andWhere('dpa.dependenceId = 0')
            ->andWhere('dpa.editionId = ' . $provaBrasilEdition->getCode())

            ->addOrderBy('dpa.disciplineId')
            ->addOrderBy('dpa.gradeId')

            ->getQuery()
            ->getResult();
    }

    public function findSchoolProficiencyByEdition(School $school, ProvaBrasilEdition $provaBrasilEdition)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder
            ->join(DimRegionalAggregation::class, 'dra', 'WITH', 'p.dimRegionalAggregationId = dra.id')
            ->andWhere('dra.schoolId = ' . $school->getId())
            ->andWhere('dra.teamId = 0')
            ->andWhere('dra.cityGroupId = 0')

            ->join(DimPoliticAggregation::class, 'dpa', 'WITH', 'p.dimPoliticAggregationId = dpa.id')
            ->andWhere('dpa.editionId = ' . $provaBrasilEdition->getCode())
            ->andWhere('dpa.disciplineId in (1, 2)')
            ->andWhere('dpa.gradeId in (5, 9)')

            ->addOrderBy('dpa.disciplineId')
            ->addOrderBy('dpa.gradeId')

            ->getQuery()
            ->getResult();
    }
}
