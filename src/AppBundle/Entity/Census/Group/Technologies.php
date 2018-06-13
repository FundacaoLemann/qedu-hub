<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technologies
 *
 * @ORM\Embeddable
 */
class Technologies
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="internet", type="boolean", nullable=true)
     */
    private $hasInternet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="banda_larga", type="boolean", nullable=true)
     */
    private $hasBroadband;

    /**
     * @var integer
     *
     * @ORM\Column(name="computadores_alunos", type="smallint", nullable=true)
     */
    private $studentComputersUnits;

    /**
     * @var integer
     *
     * @ORM\Column(name="computadores_administrativos", type="smallint", nullable=true)
     */
    private $administrativeComputersUnits;

    public function hasInternet(): ?bool
    {
        return $this->hasInternet;
    }

    public function hasBroadband(): ?bool
    {
        return $this->hasBroadband;
    }

    public function getStudentComputersUnits(): ?int
    {
        return $this->studentComputersUnits;
    }

    public function getAdministrativeComputersUnits(): ?int
    {
        return $this->administrativeComputersUnits;
    }
}
