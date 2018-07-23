<?php

namespace Tests\Fixture\Database;

trait DataWarehouseProvaBrasilTrait
{
    protected function getDatabaseName() : string
    {
        return 'waitress_dw_prova_brasil_test';
    }

    protected function getConnectionName() : string
    {
        return 'waitress_dw_prova_brasil';
    }
}
