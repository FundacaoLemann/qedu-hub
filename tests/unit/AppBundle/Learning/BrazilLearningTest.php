<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\BrazilLearning;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\LearningFixture;

class BrazilLearningTest extends TestCase
{
    public function testAddPortugueseFifthGrade()
    {
        $learning = LearningFixture::getLearning();
        $gradeId = 5;
        $disciplineId = 1;

        $brazilLearning = new BrazilLearning();
        $brazilLearning->add(
            $learning,
            $gradeId,
            $disciplineId
        );

        $learningExpected = $learning;

        $this->assertEquals($learningExpected, $brazilLearning->getPortugueseFifthGrade());
        $this->assertNull($brazilLearning->getPortugueseNinthGrade());
        $this->assertNull($brazilLearning->getMathFifthGrade());
        $this->assertNull($brazilLearning->getMathNinthGrade());
    }

    public function testAddPortugueseNinthGrade()
    {
        $learning = LearningFixture::getLearning();
        $gradeId = 9;
        $disciplineId = 1;

        $brazilLearning = new BrazilLearning();
        $brazilLearning->add(
            $learning,
            $gradeId,
            $disciplineId
        );

        $learningExpected = $learning;

        $this->assertEquals($learningExpected, $brazilLearning->getPortugueseNinthGrade());
        $this->assertNull($brazilLearning->getPortugueseFifthGrade());
        $this->assertNull($brazilLearning->getMathFifthGrade());
        $this->assertNull($brazilLearning->getMathNinthGrade());
    }

    public function testAddMathFifthGrade()
    {
        $learning = LearningFixture::getLearning();
        $gradeId = 5;
        $disciplineId = 2;

        $brazilLearning = new BrazilLearning();
        $brazilLearning->add(
            $learning,
            $gradeId,
            $disciplineId
        );

        $learningExpected = $learning;

        $this->assertEquals($learningExpected, $brazilLearning->getMathFifthGrade());
        $this->assertNull($brazilLearning->getPortugueseFifthGrade());
        $this->assertNull($brazilLearning->getPortugueseNinthGrade());
        $this->assertNull($brazilLearning->getMathNinthGrade());
    }

    public function testAddMathNinthGrade()
    {
        $learning = LearningFixture::getLearning();
        $gradeId = 9;
        $disciplineId = 2;

        $brazilLearning = new BrazilLearning();
        $brazilLearning->add(
            $learning,
            $gradeId,
            $disciplineId
        );

        $learningExpected = $learning;

        $this->assertEquals($learningExpected, $brazilLearning->getMathNinthGrade());
        $this->assertNull($brazilLearning->getPortugueseFifthGrade());
        $this->assertNull($brazilLearning->getPortugueseNinthGrade());
        $this->assertNull($brazilLearning->getMathFifthGrade());
    }
}
