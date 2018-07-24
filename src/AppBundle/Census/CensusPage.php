<?php

namespace AppBundle\Census;

use AppBundle\Component\Header;
use AppBundle\Entity\Census\OperatingConditions;
use AppBundle\Entity\School;
use AppBundle\Exception\SchoolNotFoundException;
use AppBundle\Repository\SchoolRepositoryInterface;

class CensusPage
{
    private $header;
    private $content;
    private $school;

    public function __construct(
        Header $header,
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

        if (is_null($this->school)) {
            throw new SchoolNotFoundException();
        }

        $this->header->build($this->school);

        if ($this->school->getOperatingConditionsId() === OperatingConditions::ACTIVE) {
            $this->content->build($this->school);
        }
    }

    public function getHeader() : Header
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
