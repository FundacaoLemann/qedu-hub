<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\HareNiemeyerCalculator;
use AppBundle\Learning\LearningCalculatorInterface;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\ProficiencyEntityFixture;

class HareNiemeyerCalculatorTest extends TestCase
{
    public function testHareNiemeyerCalculatorShouldImplementsLearningCalculatorInterface()
    {
        $hareNiemeyerCalculator = new HareNiemeyerCalculator();

        $this->assertInstanceOf(LearningCalculatorInterface::class, $hareNiemeyerCalculator);
    }

    public function testCalculate()
    {
        $proficiency = ProficiencyEntityFixture::getProficiencyEntities();

        $hareNiemeyerCalculator = new HareNiemeyerCalculator();
        $percentage = $hareNiemeyerCalculator->calculate($proficiency[0]);

        $percentageExpected = 50;

        $this->assertEquals($percentageExpected, $percentage);
    }
}
