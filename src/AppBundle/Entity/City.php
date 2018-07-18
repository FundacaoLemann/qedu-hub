<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="id_ibge_UNIQUE", columns={"ibge_id"})
 *     },
 *     indexes={
 *         @ORM\Index(name="fk_citie_state1", columns={"state_id"}),
 *         @ORM\Index(name="name_standard", columns={"name_standard"}),
 *         @ORM\Index(name="name", columns={"name"}),
 *         @ORM\Index(name="enem", columns={"id", "ibge_id"})
 *     }
 * )
 * @ORM\Entity
 */
class City
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
     * @var integer
     *
     * @ORM\Column(name="ibge_id", type="integer", nullable=false)
     */
    private $ibgeId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_standard", type="string", length=40, nullable=false)
     */
    private $nameStandard;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=40, nullable=false)
     */
    private $slug;

    /**
     * @var \AppBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     * })
     */
    private $state;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIbgeId(): int
    {
        return $this->ibgeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNameStandard(): string
    {
        return $this->nameStandard;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getState(): State
    {
        return $this->state;
    }
}
