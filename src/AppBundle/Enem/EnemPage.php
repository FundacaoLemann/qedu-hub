<?php

namespace AppBundle\Enem;

use AppBundle\Component\Header;
use AppBundle\Entity\School;
use AppBundle\Exception\SchoolNotFoundException;
use AppBundle\Repository\SchoolRepositoryInterface;

class EnemPage
{
    private $header;
    private $repository;
    private $school;

    public function __construct(Header $header, SchoolRepositoryInterface $repository)
    {
        $this->header = $header;
        $this->repository = $repository;
    }

    public function build($schoolId)
    {
        $this->school = $this->repository->findSchoolById($schoolId);

        if (is_null($this->school)) {
            throw new SchoolNotFoundException();
        }

        $this->header->build($this->school);
    }

    public function getHeader() : Header
    {
        return $this->header;
    }

    public function getSchool() : ?School
    {
        return $this->school;
    }
}
