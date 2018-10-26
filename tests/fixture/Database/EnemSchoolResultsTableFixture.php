<?php

namespace Tests\Fixture\Database;

class EnemSchoolResultsTableFixture extends AbstractDatabase
{
    use QeduTrait;

    public function createTable($kernel)
    {
        $this->createDatabase($kernel);

        $this->loadEntityManager($kernel);

        $this->createEnemSchoolResultsTable();
    }

    public function createEnemSchoolResultsTable()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
CREATE TABLE `enem_school_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `averageLc` decimal(5,2) NOT NULL,
  `averageMt` decimal(5,2) NOT NULL,
  `averageCh` decimal(5,2) NOT NULL,
  `averageCn` decimal(5,2) NOT NULL,
  `averageRed` decimal(6,2) NOT NULL,
  `schoolParticipation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C08EF8889E8F7F4E` (`schoolParticipation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=204195 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SQL
            )->execute();
    }

    public function populateWithEnemSchoolResultsRegister()
    {
        $this->entityManager->getConnection()
            ->prepare(<<<SQL
INSERT INTO `enem_school_results` (`id`, `averageLc`, `averageMt`, `averageCh`, `averageCn`, `averageRed`,
 `schoolParticipation_id`)
VALUES
	(43550, 429.00, 406.75, 444.25, 373.50, 500.00, 65434),
	(43551, 409.83, 433.83, 467.07, 422.03, 487.50, 65441),
	(43552, 498.50, 485.00, 507.50, 509.50, 662.50, 65446),
	(43553, 548.00, 532.50, 513.50, 491.00, 625.00, 65447),
	(117324, 603.44, 663.97, 619.42, 578.47, 648.03, 117324),
	(132691, 583.01, 612.53, 617.11, 556.02, 623.53, 129433),
	(147985, 525.26, 489.33, 561.57, 473.76, 580.00, 146846),
	(174410, 493.01, 451.77, 502.37, 440.66, 441.82, 179925);
SQL
            )->execute();
    }
}
