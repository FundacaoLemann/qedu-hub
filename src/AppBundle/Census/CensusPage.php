<?php

namespace AppBundle\Census;

use AppBundle\Entity\Census\OperatingConditions;
use AppBundle\Entity\School;
use AppBundle\Repository\SchoolRepositoryInterface;

class CensusPage
{
    private $header;
    private $content;
    private $school;

    public function __construct(
        CensusHeader $header,
        CensusContent $content,
        SchoolRepositoryInterface $schoolRepository
    ) {
        $this->header = $header;
        $this->content = $content;
        $this->schoolRepository = $schoolRepository;
    }

    public function build($schoolId)
    {
        $this->school = $this->schoolRepository->findSchoolById($schoolId);

        $this->header->build($this->school);

        if ($this->school->getOperatingConditionsId() === OperatingConditions::ACTIVE) {
            $this->content->build($this->school);
        }
    }

    public function getHeader() : CensusHeader
    {
        return $this->header;
    }

    public function getContent() : CensusContent
    {
        return $this->content;
    }

    public function getSchool() : ?School
    {
        return $this->school;
    }
}
