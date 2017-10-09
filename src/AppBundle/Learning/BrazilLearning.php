<?php

namespace AppBundle\Learning;

class BrazilLearning
{
    private $portugueseFifthGrade;
    private $portugueseNinthGrade;
    private $mathFifthGrade;
    private $mathNinthGrade;

    public function add(Learning $learning, int $gradeId, int $disciplineId)
    {
        if ($disciplineId == 1 && $gradeId === 5) {
            $this->portugueseFifthGrade = $learning;
        } elseif ($disciplineId == 1 && $gradeId === 9) {
            $this->portugueseNinthGrade = $learning;
        } elseif ($disciplineId == 2 && $gradeId === 5) {
            $this->mathFifthGrade = $learning;
        } elseif ($disciplineId == 2 && $gradeId === 9) {
            $this->mathNinthGrade = $learning;
        }
    }

    public function getPortugueseFifthGrade()
    {
        return $this->portugueseFifthGrade;
    }

    public function getPortugueseNinthGrade()
    {
        return $this->portugueseNinthGrade;
    }

    public function getMathFifthGrade()
    {
        return $this->mathFifthGrade;
    }

    public function getMathNinthGrade()
    {
        return $this->mathNinthGrade;
    }
}
