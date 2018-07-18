<?php

namespace Tests\Fixture\Database;

class StateTableFixture extends AbstractDatabase
{
    use EntitiesTrait;

    public function createStateTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `state` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `slug` varchar(40) NOT NULL,
  `ibge_id` int(11) DEFAULT NULL,
  `acronym` char(2) DEFAULT NULL,
  `region` varchar(15) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `sw_lat` float DEFAULT NULL,
  `sw_lon` float DEFAULT NULL,
  `ne_lat` float DEFAULT NULL,
  `ne_lon` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ibge_id` (`ibge_id`),
  KEY `name` (`name`),
  KEY `enem` (`id`,`ibge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    public function populateWithStateRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `state`
VALUES (
  113,
  'Minas Gerais',
  'minas-gerais',
  31,
  'MG',
  'Sudeste',
  -17.9302,
  -43.7908,
  -23.2752,
  -51.9866,
  -12.4189,
  -35.595
);
SQL
            )->execute();
    }
}
