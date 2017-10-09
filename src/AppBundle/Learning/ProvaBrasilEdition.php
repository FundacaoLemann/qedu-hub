<?php

namespace AppBundle\Learning;

class ProvaBrasilEdition
{
    private $code;
    private $year;

    public function __construct(int $code, int $year)
    {
        $this->code = $code;
        $this->year = $year;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
