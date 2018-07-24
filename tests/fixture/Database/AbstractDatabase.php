<?php

namespace Tests\Fixture\Database;

abstract class AbstractDatabase
{
    protected $entityManager;

    abstract protected function getDatabaseName() : string;
    abstract protected function getConnectionName() : string;

    public function createDatabase($kernel)
    {
        $createDatabaseCommand = sprintf("CREATE DATABASE %s;", $this->getDatabaseName());

        $kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getConnection()
            ->prepare($createDatabaseCommand)
            ->execute();
    }

    public function dropDatabase()
    {
        $dropDatabaseCommand = sprintf("DROP DATABASE %s;", $this->getDatabaseName());

        $this->entityManager->getConnection()
            ->prepare($dropDatabaseCommand)
            ->execute();
    }

    public function loadEntityManager($kernel)
    {
        $connectionName = $this->getConnectionName();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager($connectionName);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function dropTable()
    {
        $this->dropDatabase();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
