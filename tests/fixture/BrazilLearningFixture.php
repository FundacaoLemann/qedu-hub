<?php

namespace Tests\Fixture;

use AppBundle\Learning\BrazilLearning;

class BrazilLearningFixture
{
    public static function getBrazilLearning()
    {
        $brazilLearning = new BrazilLearning();

        $learning = LearningFixture::getLearning();
        $disciplineId = 1;
        $gradeId = 5;

        $brazilLearning->add(
            $learning,
            $gradeId,
            $disciplineId
        );

        return $brazilLearning;
    }
}
