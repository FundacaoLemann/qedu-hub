<?php

namespace AppBundle\Learning;

use AppBundle\Entity\Proficiency;

class HareNiemeyerCalculator implements LearningCalculatorInterface
{
    public function calculate(Proficiency $proficiency): int
    {
        $qualitativeResults = [
            $proficiency->getQualitative0(),
            $proficiency->getQualitative1(),
            $proficiency->getQualitative2(),
            $proficiency->getQualitative3(),
        ];

        $distribution = $this->perfectHundred($qualitativeResults);
        $percentage = $distribution[2] + $distribution[3];

        return $percentage;
    }

    private function perfectHundred($aData): array
    {
        $mul = 100;

        $tmp = [];
        $result = [];
        $quoteSum = 0;

        $sum = array_sum($aData);

        if ($sum == 0) {
            return $aData;
        }

        foreach ($aData as $index => $value) {
            $tmpPercentage = $value / $sum * $mul;
            $result [$index] = floor($tmpPercentage);
            $tmp [$index] = $tmpPercentage - $result [$index];
            $quoteSum += $result [$index];
        }

        arsort($tmp, SORT_NUMERIC);
        reset($tmp);
        for ($i = 0; $i < $mul - $quoteSum; $i++) {
            $result [key($tmp)]++;
            next($tmp);
        }

        return $result;
    }
}
