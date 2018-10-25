<?php

namespace AppBundle\Enem;

use AppBundle\Entity\School;

class EnemContent
{
    private $schoolRecord;
    private $filter;
    private $service;

    public function __construct(EnemFilter $enemFilter, EnemService $enemService)
    {
        $this->filter = $enemFilter;
        $this->service = $enemService;
    }

    public function build(School $school)
    {
        $this->schoolRecord = $this->service->getEnemByEdition($school);
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getEnemSchoolRecord()
    {
        return $this->schoolRecord;
    }
}
