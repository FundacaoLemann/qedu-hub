<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipments
 *
 * @ORM\Embeddable
 */
class Equipments
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="dvd", type="boolean", nullable=true)
     */
    private $hasDvd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="impressora", type="boolean", nullable=true)
     */
    private $hasPrinter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="copiadora", type="boolean", nullable=true)
     */
    private $hasCopyMachine;

    /**
     * @var boolean
     *
     * @ORM\Column(name="retroprojetor", type="boolean", nullable=true)
     */
    private $hasOverheadProjector;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tv", type="boolean", nullable=true)
     */
    private $hasTv;

    public function hasDvd(): ?bool
    {
        return $this->hasDvd;
    }

    public function hasPrinter(): ?bool
    {
        return $this->hasPrinter;
    }

    public function hasCopyMachine(): ?bool
    {
        return $this->hasCopyMachine;
    }

    public function hasOverheadProjector(): ?bool
    {
        return $this->hasOverheadProjector;
    }

    public function hasTv(): ?bool
    {
        return $this->hasTv;
    }
}
