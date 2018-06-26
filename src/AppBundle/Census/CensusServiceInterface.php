<?php

namespace AppBundle\Census;

interface CensusServiceInterface
{
    public function getCensusByEdition($entity);
}
