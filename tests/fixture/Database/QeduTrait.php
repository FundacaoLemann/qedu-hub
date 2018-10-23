<?php

namespace Tests\Fixture\Database;

trait QeduTrait
{
    protected function getDatabaseName() : string
    {
        return 'qedu_test';
    }

    protected function getConnectionName() : string
    {
        return 'qedu';
    }
}
