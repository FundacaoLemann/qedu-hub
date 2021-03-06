<?php

namespace Tests\Fixture;

use AppBundle\Entity\DimPoliticAggregation;
use AppBundle\Entity\DimRegionalAggregation;
use AppBundle\Entity\Proficiency;

class ProficiencyEntityFixture
{
    public static function getProficiencyEntities()
    {
        return [
            self::getProficiency(),
        ];
    }

    public static function getProficiency()
    {
        $dimRegionalAggregation = self::getDimRegionalAggregation();
        $dimPoliticAggregation = self::getDimPoliticAggregation();

        $proficiency = new Proficiency();
        $proficiency->setDimRegionalAggregation($dimRegionalAggregation);
        $proficiency->setDimPoliticAggregation($dimPoliticAggregation);
        $proficiency->setWithProficiencyWeight('2438249.00');
        $proficiency->setLevelOptimal('1225082.10');
        $proficiency->setQualitative0('360308.55');
        $proficiency->setQualitative1('852858.35');
        $proficiency->setQualitative2('812656.05');
        $proficiency->setQualitative3('412426.06');

        return $proficiency;
    }

    public static function getDimRegionalAggregation()
    {
        return new DimRegionalAggregation();
    }

    public static function getDimPoliticAggregation()
    {
        $dimPoliticAggregation = new DimPoliticAggregation();
        $dimPoliticAggregation->setDependenceId(0);
        $dimPoliticAggregation->setDisciplineId(1);
        $dimPoliticAggregation->setEditionId(6);
        $dimPoliticAggregation->setGradeId(5);
        $dimPoliticAggregation->setLocalizationId(0);

        return $dimPoliticAggregation;
    }
}
