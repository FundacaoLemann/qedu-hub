<?php

namespace AppBundle\Entity\Census\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accessibility
 *
 * @ORM\Embeddable
 */
class Accessibility
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="dependencias", type="boolean", nullable=true)
     */
    private $hasAccessibilityInDependencies;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sanitario", type="boolean", nullable=true)
     */
    private $hasAccessibilityInToilets;

    public function hasAccessibilityInDependencies(): ?bool
    {
        return $this->hasAccessibilityInDependencies;
    }
    public function hasAccessibilityInToilets(): ?bool
    {
        return $this->hasAccessibilityInToilets;
    }
}
