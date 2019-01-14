<?php

namespace AppBundle\Learning;

class ProvaBrasilService
{
    public function getLastEdition()
    {
        return new ProvaBrasilEdition(7, 2017);
    }
}
