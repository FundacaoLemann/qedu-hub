<?php

namespace AppBundle\Census;

class CensusEdition
{
    private $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
