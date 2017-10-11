<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\BrazilLearning;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\LearningFixture;

class BrazilLearningTest extends TestCase
{
    /**
     * @dataProvider learningProvider
     */
    public function testAddShouldSetLearningAccordingGradeAndDiscipline(
        $gradeId,
        $disciplineId,
        $methodTarget
    ) {
        $learning = LearningFixture::getLearning();

        $brazilLearning = new BrazilLearning();
        $brazilLearning->add(
            $learning,
            $gradeId,
            $disciplineId
        );

        $learningExpected = $learning;

        $this->assertEquals($learningExpected, $brazilLearning->{$methodTarget}());
    }

    public function learningProvider()
    {
        return [
            [
                'gradeId' => 5,
                'disciplineId' => 1,
                'methodTarget' => 'getPortugueseFifthGrade',
            ],
            [
                'gradeId' => 9,
                'disciplineId' => 1,
                'methodTarget' => 'getPortugueseNinthGrade',
            ],
            [
                'gradeId' => 5,
                'disciplineId' => 2,
                'methodTarget' => 'getMathFifthGrade',
            ],
            [
                'gradeId' => 9,
                'disciplineId' => 2,
                'methodTarget' => 'getMathNinthGrade',
            ],
        ];
    }
}
