<?php

namespace Tests\Fixture\Database;

trait EntitiesTrait
{
    protected function getDatabaseName() : string
    {
        return 'waitress_entities_test';
    }

    protected function getConnectionName() : string
    {
        return 'waitress_entities';
    }
}
