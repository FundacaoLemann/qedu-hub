<?php

namespace Tests\Fixture;

use AppBundle\Learning\Learning;

class LearningFixture
{
    public static function getLearning(): Learning
    {
        $percentage = 50;
        $proficiency = ProficiencyEntityFixture::getProficiency();

        $learning = new Learning(
            $proficiency,
            $percentage
        );

        return $learning;
    }

    public static function getLearningCollection(): array
    {
        $learningCollection = [];

        $learningCollection[] = self::getLearning();

        return $learningCollection;
    }
}
