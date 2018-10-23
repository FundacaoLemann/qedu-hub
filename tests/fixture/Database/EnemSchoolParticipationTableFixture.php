<?php

namespace Tests\Fixture\Database;

class EnemSchoolParticipationTableFixture extends AbstractDatabase
{
    use QeduTrait;

    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createEnemSchoolParticipationTable();
    }

    public function createEnemSchoolParticipationTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `enem_school_participation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) DEFAULT NULL,
  `edition` int(11) NOT NULL,
  `participationCount` int(11) NOT NULL,
  `participationRate` decimal(5,4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_SCHOOL_PARTICIPATION` (`edition`,`school_id`),
  KEY `IDX_5159509AC32A47EE` (`school_id`),
  CONSTRAINT `FK_5159509AC32A47EE` FOREIGN KEY (`school_id`) REFERENCES `education_entity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SQL
            )->execute();
    }

    public function populateWithEnemSchoolParticipationRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `enem_school_participation` (`id`, `school_id`, `edition`, `participationCount`, `participationRate`)
VALUES
	(43550, 90356, 2012, 36, 0.6667),
	(43551, 90356, 2009, 17, 0.2329),
	(43552, 90356, 2010, 24, 0.4615),
	(43553, 90356, 2011, 39, 0.5909),
	(117324, 90356, 2013, 39, 0.8298),
	(132691, 90356, 2014, 35, 0.6604),
	(147985, 90356, 2015, 36, 0.6667),
	(174410, 90356, 2016, 40, 0.9302),
	(205949, 90356, 2017, 31, 0.7209);
SQL
            )->execute();
    }
}
