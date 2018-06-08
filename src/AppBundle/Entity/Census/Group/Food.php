<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * Food
 *
 * @ORM\Embeddable
 */
class Food
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="fornecida", type="boolean", nullable=true)
     */
    private $hasFoodProvided;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agua_filtrada", type="boolean", nullable=true)
     */
    private $hasFilteredWater;

    public function hasFoodProvided(): ?bool
    {
        return $this->hasFoodProvided;
    }

    public function hasFilteredWater(): ?bool
    {
        return $this->hasFilteredWater;
    }
}
