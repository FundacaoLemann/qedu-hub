<?php

namespace Tests\Fixture\Database;

class EducationEntityTableFixture extends AbstractDatabase
{
    use QeduTrait;

    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createEducationEntityTable();
    }

    public function createEducationEntityTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `education_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `ibgeId` int(11) DEFAULT NULL,
  `slug` varchar(222) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `shortName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `oldId` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_ibge_id` (`type`,`ibgeId`,`oldId`),
  KEY `IDX_4626FE39989D9B62` (`slug`),
  KEY `IDX_4626FE3964D218E` (`location_id`),
  KEY `IDX_SEARCH_OLD_ENTITY` (`type`,`oldId`),
  CONSTRAINT `FK_4626FE3964D218E` FOREIGN KEY (`location_id`) REFERENCES `education_entity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SQL
            )->execute();
    }

    public function populateWithEducationEntityRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `education_entity` (`id`, `location_id`, `ibgeId`, `slug`, `name`, `shortName`, `oldId`, `type`)
VALUES
	(1, NULL, NULL, 'brasil', 'Brasil', 'BR', 100, 'country'),
	(26, 1, 35, 'sao-paulo', 'São Paulo', 'SP', 125, 'state'),
	(3383, 26, 3550308, 'sao-paulo', 'São Paulo', 'SAO PAULO', 2329, 'city'),
	(90356, 3383, 35107542, 'pueri-domus-escola-verbo-divino-unidade-i', 'PUERI DOMUS ESCOLA VERBO DIVINO UNIDADE I',
	 'PUERI DOMUS ESCOLA VERBO DIVINO UNIDADE I', 212104, 'school');
SQL
            )->execute();
    }
}
