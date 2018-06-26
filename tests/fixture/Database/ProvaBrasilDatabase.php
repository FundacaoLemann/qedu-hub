<?php

namespace Tests\Fixture\Database;

abstract class ProvaBrasilDatabase
{
    protected $entityManager;

    public function createDatabase($kernel)
    {
        $kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getConnection()
            ->prepare("CREATE DATABASE waitress_dw_prova_brasil_test;")
            ->execute();
    }

    public function dropDatabase()
    {
        $this->entityManager->getConnection()
            ->prepare("DROP DATABASE waitress_dw_prova_brasil_test;")
            ->execute();
    }

    public function loadEntityManager($kernel)
    {
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager('waitress_dw_prova_brasil');
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
