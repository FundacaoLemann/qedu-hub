<?php

namespace Tests\Fixture;

use AppBundle\Learning\Learning;

class LearningFixture
{
    public static function getLearning(): Learning
    {
        $percentage = 50;
        $totalSuccessfulStudents = 1225082;
        $totalStudents = 2438249;

        $learning = new Learning(
            $percentage,
            $totalSuccessfulStudents,
            $totalStudents
        );

        return $learning;
    }
}
