<?php

namespace AppBundle\Enem;

use AppBundle\Entity\School;
use AppBundle\Repository\Enem\EnemSchoolParticipationRepositoryInterface;
use AppBundle\Repository\Enem\EnemSchoolResultsRepositoryInterface;

class EnemService implements EnemServiceInterface
{
    private $schoolParticipationRepository;
    private $schoolResultsRepository;
    private $enemEditionSelected;

    public function __construct(
        EnemSchoolParticipationRepositoryInterface $schoolParticipationRepository,
        EnemSchoolResultsRepositoryInterface $schoolResultsRepository,
        EnemEditionSelected $enemEditionSelected
    ) {
        $this->schoolParticipationRepository = $schoolParticipationRepository;
        $this->schoolResultsRepository = $schoolResultsRepository;
        $this->enemEditionSelected = $enemEditionSelected;
    }

    public function getEnemByEdition(School $school)
    {
        $enemEdition = $this->enemEditionSelected->getEnemEdition();

        $enemSchoolParticipation = $this->schoolParticipationRepository
            ->findEnemSchoolParticipationByEdition($school, $enemEdition);

        if (!$enemSchoolParticipation) {
            return new EnemSchoolRecord(null, null);
        }

        $enemSchoolResults = $this->schoolResultsRepository
            ->findEnemSchoolResultsByEnemSchoolParticipation($enemSchoolParticipation);

        $enemSchoolRecord = new EnemSchoolRecord($enemSchoolParticipation, $enemSchoolResults);

        return $enemSchoolRecord;
    }
}
