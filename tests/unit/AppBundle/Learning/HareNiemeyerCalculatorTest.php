<?php

namespace Tests\Unit\AppBundle\Learning;

use AppBundle\Entity\Proficiency;
use AppBundle\Learning\HareNiemeyerCalculator;
use AppBundle\Learning\LearningCalculatorInterface;
use PHPUnit\Framework\TestCase;

class HareNiemeyerCalculatorTest extends TestCase
{
    public function testHareNiemeyerCalculatorShouldImplementsLearningCalculatorInterface()
    {
        $hareNiemeyerCalculator = new HareNiemeyerCalculator();

        $this->assertInstanceOf(LearningCalculatorInterface::class, $hareNiemeyerCalculator);
    }

    /**
     * @dataProvider proficiencyDataProvider
     */
    public function testCalculate($qualitative, $percentageExpected)
    {
        $proficiency = new Proficiency();
        $proficiency->setQualitative0($qualitative[0]);
        $proficiency->setQualitative1($qualitative[1]);
        $proficiency->setQualitative2($qualitative[2]);
        $proficiency->setQualitative3($qualitative[3]);

        $hareNiemeyerCalculator = new HareNiemeyerCalculator();
        $percentage = $hareNiemeyerCalculator->calculate($proficiency);

        $this->assertEquals($percentageExpected, $percentage);
    }

    public function proficiencyDataProvider(): array
    {
        return [
            [
                'qualitative' => [
                    '360308.55',
                    '852858.35',
                    '812656.05',
                    '412426.06'
                ],
                'percentageExpected' => 50,
            ],
            [
                'qualitative' => [
                    '515218.34',
                    '979617.59',
                    '676757.03',
                    '266656.04'
                ],
                'percentageExpected' => 39,
            ],
            [
                'qualitative' => [
                    '373266.07',
                    '1094935.19',
                    '529791.17',
                    '99636.82'
                ],
                'percentageExpected' => 30,
            ],
            [
                'qualitative' => [
                    '646121.21',
                    '1160289.70',
                    '256269.77',
                    '34948.56'
                ],
                'percentageExpected' => 14,
            ],
            [
                'qualitative' => [
                    '0.00',
                    '0.00',
                    '0.00',
                    '0.00'
                ],
                'percentageExpected' => 0,
            ],
        ];
    }
}
