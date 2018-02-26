<?php

namespace Tests\Fixture\Database;

class SchoolTableFixture
{
    private $entityManager;

    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createSchoolTable();
    }

    public function createDatabase($kernel)
    {
        $kernel->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getConnection()
            ->prepare("CREATE DATABASE waitress_entities_test;")
            ->execute();
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function dropTable()
    {
        $this->entityManager->getConnection()
            ->prepare("DROP DATABASE waitress_entities_test;")
            ->execute();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    private function loadEntityManager($kernel)
    {
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager('waitress_entities');
    }

    private function createSchoolTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `school` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(5) unsigned NOT NULL,
  `state_id` tinyint(3) unsigned NOT NULL,
  `ibge_id` int(11) NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `name` varchar(120) NOT NULL,
  `name_prefix` varchar(30) DEFAULT NULL,
  `name_standard` varchar(100) DEFAULT NULL,
  `slug` varchar(140) DEFAULT NULL,
  `district` varchar(60) DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `address_number` varchar(20) DEFAULT NULL,
  `address_complement` varchar(30) DEFAULT NULL,
  `address_cep` char(8) DEFAULT NULL,
  `ddd` char(2) DEFAULT NULL,
  `phone` char(8) DEFAULT NULL,
  `public_phone` char(8) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `dependence_id` tinyint(3) unsigned NOT NULL,
  `localization_id` tinyint(3) unsigned NOT NULL,
  `operating_conditions_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ibge` (`ibge_id`),
  UNIQUE KEY `enem` (`id`,`city_id`,`state_id`,`ibge_id`),
  KEY `fk_school_dependence1` (`dependence_id`),
  KEY `fk_school_localization1` (`localization_id`),
  KEY `fk_school_operating_conditions1` (`operating_conditions_id`),
  KEY `name` (`name_standard`(9)),
  KEY `prefix_and_name` (`name_prefix`,`name_standard`),
  KEY `fk_school_city1` (`city_id`),
  KEY `fk_school_state1` (`state_id`),
  KEY `fast_search` (`state_id`,`city_id`,`id`),
  KEY `name_2` (`name`),
  KEY `city_name` (`city_id`,`name`),
  KEY `Enem Average` (`ibge_id`,`state_id`,`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=156486 DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    public function populateWithSchoolRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `school`
VALUES (
  142950, 
  1597, 
  113, 
  31171166, 
  1, 
  'EM FAZENDA AGUAS VERDES', 
  'EM', 
  'FAZENDA AGUAS VERDES', 
  'em-fazenda-aguas-verdes', 
  NULL, 
  'FAZ AGUAS VERDES', 
  '0', 
  '1', 
  '37170000', 
  '35', 
  '38511660', 
  NULL, 
  NULL, 
  3, 
  2, 
  1
);
SQL
            )->execute();
    }
}
