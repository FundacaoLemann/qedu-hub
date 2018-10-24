<?php

namespace AppBundle\Enem;

use AppBundle\Entity\Enem\School;
use AppBundle\Repository\Enem\EnemSchoolRepositoryInterface;

class EnemService implements EnemServiceInterface
{
    private $schoolRepository;
    private $enemEditionSelected;

    public function __construct(
        EnemSchoolRepositoryInterface $schoolRepository,
        EnemEditionSelected $enemEditionSelected
    ) {
        $this->schoolRepository = $schoolRepository;
        $this->enemEditionSelected = $enemEditionSelected;
    }

    public function getEnemByEdition($school)
    {
        $enemEdition = $this->enemEditionSelected->getEnemEdition();
        $enemSchoolParticipation = $this->schoolRepository->findEnemSchoolParticipationByEdition($school, $enemEdition);
        $enemSchoolRecord = new EnemSchoolRecord($enemSchoolParticipation);

        return $enemSchoolRecord;
    }
}
