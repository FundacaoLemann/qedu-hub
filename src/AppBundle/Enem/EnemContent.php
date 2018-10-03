<?php
namespace AppBundle\Enem;

class EnemContent
{
    private $filter;

    public function __construct(EnemFilter $filter)
    {
        $this->filter = $filter;
    }

    public function getFilter()
    {
        return $this->filter;
    }
}
