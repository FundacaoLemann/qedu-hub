<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * OthersInformation
 *
 * @ORM\Embeddable
 */
class OthersInformation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="num_funcionarios", type="smallint", nullable=true)
     */
    private $employeesNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="organizacao_ciclos", type="boolean", nullable=true)
     */
    private $hasOrganizationByCycles;

    public function getEmployeesNumber(): ?int
    {
        return $this->employeesNumber;
    }

    public function hasOrganizationByCycles(): ?bool
    {
        return $this->hasOrganizationByCycles;
    }
}
