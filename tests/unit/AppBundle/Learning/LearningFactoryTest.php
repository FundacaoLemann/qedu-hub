<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Learning\LearningFactory;
use PHPUnit\Framework\TestCase;
use Tests\Fixture\BrazilLearningFixture;
use Tests\Fixture\ProficiencyEntityFixture;

class LearningFactoryTest extends TestCase
{
    public function testCreateShouldReturnValidBrazilianLearning()
    {
        $proficiencies = ProficiencyEntityFixture::getProficiencyEntities();
        $proficiencyPercentage = 50;

        $learningCalculatorMock = $this->createMock('AppBundle\Learning\LearningCalculatorInterface');
        $learningCalculatorMock->expects($this->once())
            ->method('calculate')
            ->with($proficiencies[0])
            ->willReturn($proficiencyPercentage);

        $learningFactory = new LearningFactory($learningCalculatorMock);
        $brazilLearning = $learningFactory->create($proficiencies);

        $brazilLearningExpected = BrazilLearningFixture::getBrazilLearning();

        $this->assertEquals($brazilLearningExpected, $brazilLearning);
    }
}
