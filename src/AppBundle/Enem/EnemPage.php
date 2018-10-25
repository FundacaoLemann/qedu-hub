<?php

namespace AppBundle\Enem;

use AppBundle\Component\Header;
use AppBundle\Entity\School;
use AppBundle\Exception\SchoolNotFoundException;
use AppBundle\Repository\SchoolRepositoryInterface;

class EnemPage
{
    private $content;
    private $header;
    private $repository;
    private $school;

    public function __construct(Header $header, SchoolRepositoryInterface $repository, EnemContent $content)
    {
        $this->header = $header;
        $this->repository = $repository;
        $this->content = $content;
    }

    public function build($schoolId)
    {
        $this->school = $this->repository->findSchoolById($schoolId);

        if (is_null($this->school)) {
            throw new SchoolNotFoundException();
        }

        $this->header->build($this->school);
        $this->content->build($this->school);
    }

    public function getContent() : EnemContent
    {
        return $this->content;
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
