<?php

namespace Tests\Fixture\Database;

class ProficiencyTableFixture extends AbstractDatabase
{
    use DataWarehouseProvaBrasilTrait;

    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createProficiencyTable();
        $this->createDimRegionalAggregationTable();
        $this->createDimPoliticAggregationTable();
    }

    public function populateWithBrazilRegister()
    {
        $this->createBrazilProficiencyRegister();
        $this->createBrazilDimRegionalAggregationRegister();
        $this->createBrazilDimPoliticAggregationRegister();
    }

    public function populateWithSchoolRegister()
    {
        $this->createSchoolProficiencyRegister();
        $this->createSchoolDimRegionalAggregationRegister();
        $this->createSchoolDimPoliticAggregationRegister();
    }

    private function createProficiencyTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `fact_proficiency` (
  `dim_regional_aggregation_id` mediumint(8) unsigned NOT NULL,
  `dim_politic_aggregation_id` mediumint(8) unsigned NOT NULL,
  `partition_state_id` tinyint(3) unsigned NOT NULL,
  `enrolled` int(10) unsigned NOT NULL,
  `presents` int(10) unsigned NOT NULL,
  `with_proficiency` int(11) NOT NULL,
  `with_proficiency_weight` decimal(10,2) NOT NULL,
  `average` decimal(5,2) unsigned NOT NULL,
  `level_quantitative` tinyint(3) unsigned NOT NULL,
  `level_qualitative` tinyint(3) unsigned NOT NULL,
  `level_optimal` decimal(10,2) unsigned NOT NULL,
  `qualitative_0` decimal(10,2) unsigned NOT NULL,
  `qualitative_1` decimal(10,2) unsigned NOT NULL,
  `qualitative_2` decimal(10,2) unsigned NOT NULL,
  `qualitative_3` decimal(10,2) unsigned NOT NULL,
  `disclosure` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`dim_regional_aggregation_id`,`dim_politic_aggregation_id`,`partition_state_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
SQL
            )->execute();
    }

    private function createDimRegionalAggregationTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `dim_regional_aggregation` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` tinyint(3) unsigned DEFAULT NULL,
  `city_id` smallint(5) unsigned DEFAULT NULL,
  `school_id` mediumint(8) unsigned DEFAULT NULL,
  `team_id` int(10) unsigned DEFAULT NULL,
  `city_group_id` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `busca` (`state_id`,`city_id`,`school_id`,`team_id`) USING BTREE,
  KEY `city_group` (`state_id`,`city_group_id`),
  KEY `city_group_unique` (`state_id`,`city_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    private function createDimPoliticAggregationTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `dim_politic_aggregation` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `dependence_id` tinyint(4) DEFAULT NULL,
  `localization_id` tinyint(4) DEFAULT NULL,
  `edition_id` tinyint(4) DEFAULT NULL,
  `grade_id` tinyint(4) DEFAULT NULL,
  `discipline_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `busca` (`dependence_id`,`localization_id`,`edition_id`,`grade_id`,`discipline_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
SQL
            )->execute();
    }

    private function createBrazilDimPoliticAggregationRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `dim_politic_aggregation` 
VALUES
	(937, 0, 0, 6, 5, 1),
	(938, 0, 0, 6, 5, 2),
	(940, 0, 0, 6, 9, 1),
	(941, 0, 0, 6, 9, 2);
SQL
            )->execute();
    }

    private function createBrazilDimRegionalAggregationRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `dim_regional_aggregation` (`id`, `state_id`, `city_id`, `school_id`, `team_id`, `city_group_id`)
VALUES
(1, 100, 0, 0, 0, 0);
SQL
            )->execute();
    }

    private function createBrazilProficiencyRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `fact_proficiency` (
    `dim_politic_aggregation_id`, 
    `dim_regional_aggregation_id`, 
    `with_proficiency_weight`, 
    `level_optimal`, 
    `qualitative_0`, 
    `qualitative_1`, 
    `qualitative_2`, 
    `qualitative_3`
) VALUES
	(937, 1, 2438249.00, 1225082.10, 360308.55, 852858.35, 812656.05, 412426.06),
	(940, 1, 2097629.24, 629427.98, 373266.07, 1094935.19, 529791.17, 99636.82),
	(938, 1, 2438249.00, 943413.08, 515218.34, 979617.59, 676757.03, 266656.04),
	(941, 1, 2097629.24, 291218.33, 646121.21, 1160289.70, 256269.77, 34948.56);
SQL
            )->execute();
    }

    private function createSchoolDimPoliticAggregationRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `dim_politic_aggregation` 
VALUES
	(874, 3, 2, 6, 5, 1),
	(875, 3, 2, 6, 5, 2),
	(877, 3, 2, 6, 9, 1),
	(878, 3, 2, 6, 9, 2);
SQL
            )->execute();
    }

    private function createSchoolDimRegionalAggregationRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `dim_regional_aggregation` (`id`, `state_id`, `city_id`, `school_id`, `team_id`, `city_group_id`)
VALUES
	(30945, 113, 1597, 142950, 0, 0);
SQL
            )->execute();
    }

    private function createSchoolProficiencyRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `fact_proficiency` (
    `dim_politic_aggregation_id`, 
    `dim_regional_aggregation_id`, 
    `partition_state_id`,
    `with_proficiency_weight`, 
    `level_optimal`, 
    `qualitative_0`, 
    `qualitative_1`, 
    `qualitative_2`, 
    `qualitative_3`
) VALUES
	(874, 30945, 113, 25.02, 7.30, 5.21, 12.51, 4.17, 3.13),
	(877, 30945, 113, 36.01, 12.19, 3.13, 20.69, 11.19, 1.00),
	(875, 30945, 113, 25.02, 9.38, 4.17, 11.47, 7.30, 2.09),
	(878, 30945, 113, 36.01, 1.06, 4.19, 30.76, 1.06, 0.00);
SQL
            )->execute();
    }
}
