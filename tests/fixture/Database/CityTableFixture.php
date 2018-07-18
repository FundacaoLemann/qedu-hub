<?php

namespace Tests\Fixture\Database;

class CityTableFixture extends AbstractDatabase
{
    use EntitiesTrait;

    public function createCityTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `city` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` tinyint(3) unsigned NOT NULL,
  `ibge_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `name_standard` varchar(40) NOT NULL,
  `slug` varchar(40) NOT NULL,
  `lat` float DEFAULT NULL COMMENT 'central latitude',
  `lon` float DEFAULT NULL COMMENT 'central longitude',
  `sw_lat` float DEFAULT NULL COMMENT 'south-west latitude point',
  `sw_lon` float DEFAULT NULL COMMENT 'south-west longitude point',
  `ne_lat` float DEFAULT NULL COMMENT 'northeast latitude point',
  `ne_lon` float DEFAULT NULL COMMENT 'northeast longitude point',
  `cep` char(8) DEFAULT NULL,
  `ddd` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_ibge_UNIQUE` (`ibge_id`),
  KEY `fk_citie_state1` (`state_id`),
  KEY `name_standard` (`name_standard`),
  KEY `name` (`name`),
  KEY `enem` (`id`,`ibge_id`),
  CONSTRAINT `fk_citie_state1` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    public function populateWithCityRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `city`
VALUES (
  1597,
  113,
  3107109,
  'Boa Esperança',
  'BOA ESPERANCA',
  'boa-esperanca',
  -21.0941,
  -45.5746,
  -21.1773,
  -45.7026,
  -21.0108,
  -45.4465,
  '37170000',
  '44'
);
SQL
            )->execute();
    }
}
