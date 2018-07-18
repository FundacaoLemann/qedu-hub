<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="ibge_id", columns={"ibge_id"})
 *     },
 *     indexes={
 *         @ORM\Index(name="name", columns={"name"}),
 *         @ORM\Index(name="enem", columns={"id", "ibge_id"})
 *     }
 * )
 * @ORM\Entity
 */
class State
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=40, nullable=false)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="ibge_id", type="integer", nullable=true)
     */
    private $ibgeId;

    /**
     * @var string
     *
     * @ORM\Column(name="acronym", type="string", length=2, nullable=true)
     */
    private $acronym;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=15, nullable=true)
     */
    private $region;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getIbgeId(): int
    {
        return $this->ibgeId;
    }

    public function getAcronym(): string
    {
        return $this->acronym;
    }

    public function getRegion(): string
    {
        return $this->region;
    }
}
