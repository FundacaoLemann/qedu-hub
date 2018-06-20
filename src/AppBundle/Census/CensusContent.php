<?php

namespace AppBundle\Census;

class CensusContent
{
    private $filter;
    private $censusService;
    private $censusData;

    public function __construct(CensusFilter $filter, CensusServiceInterface $censusService)
    {
        $this->filter = $filter;
        $this->censusService = $censusService;
    }

    public function build($entity)
    {
        $this->censusData = $this->censusService->getCensusByEdition($entity);
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getCensusData()
    {
        return $this->censusData;
    }
}
