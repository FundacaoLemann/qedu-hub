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

    private function perfectHundred($aData,  $aPrec = 0) {
        if (!is_array($aData))
            return array();

        $aDataOriginal = $aData;
        $aData = array_values($aData);

        if (array_sum($aDataOriginal) == 0)
            return $aDataOriginal;

        $mul = 100;
        if ($aPrec > 0 && $aPrec < 3) {
            if ($aPrec == 1)
                $mul = 1000;
            else
                $mul = 10000;
        }

        $tmp = array();
        $result = array();
        $quote_sum = 0;
        $n = count ( $aData );
        for($i = 0, $sum = 0; $i < $n; ++ $i)
            $sum += $aData [$i];

        foreach ( $aData as $index => $value ) {
            $tmp_percentage = $value / $sum * $mul;
            $result [$index] = floor ( $tmp_percentage );
            $tmp [$index] = $tmp_percentage - $result [$index];
            $quote_sum += $result [$index];
        }
        if ($quote_sum == $mul) {
            if ($mul > 100) {
                $tmp = $mul / 100;
                for($i = 0; $i < $n; ++ $i) {
                    $result [$i] /= $tmp;
                }
            }
        } else {
            arsort ( $tmp, SORT_NUMERIC );
            reset ( $tmp );
            for($i = 0; $i < $mul - $quote_sum; $i ++) {
                $result [key ( $tmp )] ++;
                next ( $tmp );
            }
            if ($mul > 100) {
                $tmp = $mul / 100;
                for($i = 0; $i < $n; ++ $i) {
                    $result [$i] /= $tmp;
                }
            }
        }

        $i = 0;
        foreach($aDataOriginal as $k => &$v)
            $v = $result[$i++];

        return $aDataOriginal;
    }
}
