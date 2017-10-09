<?php

namespace Tests\Fixture;

use AppBundle\Entity\DimPoliticAggregation;
use AppBundle\Entity\DimRegionalAggregation;
use AppBundle\Entity\Proficiency;

class ProficiencyEntityFixture
{
    public static function getProficiencyEntities()
    {
        $dimRegionalAggregation = new DimRegionalAggregation();

        $dimPoliticAggregation = new DimPoliticAggregation();
        $dimPoliticAggregation->setDependenceId(0);
        $dimPoliticAggregation->setDisciplineId(1);
        $dimPoliticAggregation->setEditionId(6);
        $dimPoliticAggregation->setGradeId(5);
        $dimPoliticAggregation->setLocalizationId(0);

        $proficiency = new Proficiency();
        $proficiency->setDimRegionalAggregation($dimRegionalAggregation);
        $proficiency->setDimPoliticAggregation($dimPoliticAggregation);
        $proficiency->setWithProficiencyWeight('1225082.10');
        $proficiency->setLevelOptimal('2438249.00');
        $proficiency->setQualitative0('360308.55');
        $proficiency->setQualitative1('852858.35');
        $proficiency->setQualitative2('812656.05');
        $proficiency->setQualitative3('412426.06');

        return [
            $proficiency,
        ];
    }
}
