<?php

namespace AppBundle\Learning;

class Learning
{
    private $percentage;
    private $totalSuccessfulStudents;
    private $totalStudents;

    public function __construct(int $percentage, int $totalSuccessfulStudents, int $totalStudents)
    {
        $this->percentage= $percentage;
        $this->totalSuccessfulStudents= $totalSuccessfulStudents;
        $this->totalStudents= $totalStudents;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }

    public function getTotalSuccessfulStudents(): int
    {
        return $this->totalSuccessfulStudents;
    }

    public function getTotalStudents(): int
    {
        return $this->totalStudents;
    }
}
