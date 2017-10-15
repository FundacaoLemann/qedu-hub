<?php

namespace AppBundle\Repository;

use AppBundle\Entity\DimPoliticAggregation;
use AppBundle\Entity\DimRegionalAggregation;
use AppBundle\Learning\ProvaBrasilEdition;
use Doctrine\ORM\EntityRepository;

class ProficiencyRepository extends EntityRepository implements ProficiencyRepositoryInterface
{
    public function findBrazilProficiencyByEdition(ProvaBrasilEdition $provaBrasilEdition)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $editionCode = $provaBrasilEdition->getCode();

        return $queryBuilder
            ->join(DimRegionalAggregation::class, 'dra', 'WITH', 'p.dimRegionalAggregationId = dra.id')
            ->andWhere('dra.stateId = 100')
            ->andWhere('dra.schoolId = 0')
            ->andWhere('dra.cityId = 0')

            ->join(DimPoliticAggregation::class, 'dpa', 'WITH', 'p.dimPoliticAggregationId = dpa.id')
            ->andWhere('dpa.localizationId = 0')
            ->andWhere('dpa.dependenceId = 0')

            ->andWhere('dpa.editionId= '.$editionCode)
            ->getQuery()
            ->getResult();
    }
}
