<?php

namespace Tests\Fixture\Database;

class SchoolLearningTableFixture extends AbstractDatabase
{
    use DataWarehouseProvaBrasilTrait;

    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createSchoolLearningTable();
    }

    public function createSchoolLearningTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `school` (
  `id` int(10) unsigned NOT NULL,
  `edition_id` tinyint(3) unsigned NOT NULL,
  `state_id` tinyint(4) NOT NULL,
  `city_id` smallint(6) NOT NULL,
  `localization_id` tinyint(4) DEFAULT NULL,
  `dependence_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`edition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    public function populateWithSchoolRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `school` (`id`, `edition_id`, `state_id`, `city_id`, `localization_id`, `dependence_id`)
VALUES
(142950, 6, 113, 1597, 2, 3),
(142950, 7, 113, 1597, 2, 3);
SQL
            )->execute();
    }
}
