<?php

namespace Tests\Fixture;

use AppBundle\Learning\ProvaBrasilEdition;

class ProvaBrasilEditionFixture
{
    public static function getProvaBrasilEdition()
    {
        return new ProvaBrasilEdition(6, 2015);
    }
}
